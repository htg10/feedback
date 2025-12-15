<?php

namespace App\Http\Controllers;

use App\Models\Building;
use App\Models\Department;
use App\Models\Feedback;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class OtpController extends Controller
{
    // public function showForm()
    // {
    //     $rooms = Room::all();
    //     $users = User::with('departments')->get();
    //     return view('otp', compact('rooms', 'users'));
    // }

    public function showForm($slug)
    {
        // Find building by slug or fail
        $building = Building::where('slug', $slug)->firstOrFail();

        // Get only rooms that belong to this building
        $rooms = Room::whereHas('floors', function ($query) use ($building) {
            $query->where('building_id', $building->id);
        })->with(['floors', 'buildings'])->get();

        // Get all users with departments (if needed for your form)
        $users = User::with('departments')->get();

        return view('otp', compact('rooms', 'users', 'building'));
    }

    public function trackComplaint(Request $request)
    {
        $request->validate([
            'track_input' => 'required'
        ]);

        $input = $request->track_input;

        // Check if input is Mobile
        if (preg_match('/^[0-9]{10}$/', $input)) {
            $complaint = Feedback::where('mobile', $input)
                ->orderBy('id', 'DESC')
                ->first();
        } else {
            // Treat as Complaint Unique ID
            $complaint = Feedback::where('unique_id', $input)->first();
        }

        if (!$complaint) {
            return back()->with('track_error', 'No complaint found!');
        }

        // Decide alert type based on status
        $status = strtolower($complaint->status);
        $alertClass = 'alert-info';

        if ($status == 'pending') {
            $alertClass = 'alert-danger';
        } elseif ($status == 'complete' || $status == 'completed') {
            $alertClass = 'alert-success';
        }

        // Pass status and alert class to session
        return back()->with([
            'track_status' => "Complaint Status: " . ucfirst($complaint->status),
            'track_alert_class' => $alertClass
        ]);
    }

    public function sendOtp(Request $request)
    {
        $request->validate([
            'mobile' => 'required|digits:10'
        ]);

        // Generate random 6-digit OTP
        $otp = rand(100000, 999999);
        $mobile = $request->mobile;

        // Store OTP in session (or database for production)
        Session::put('otp', $otp);
        Session::put('mobile', $mobile);
        Session::put('is_verified', false);

        // Feedback::create(
        //     [
        //         'mobile' => $mobile,
        //         'otp' => $otp,
        //         'is_verified' => false,
        //     ]
        // );

        // Send SMS API
        $username = 'helptogether8';
        $password = '63278934';
        $header = 'RLWORH';
        $templateId = '1207176101245594177';
        $message = "Your OTP for the Rail ORH Portal is $otp. Please enter this code to validate your mobile number. Thank you, Developed By Help Together Group";

        $response = Http::asForm()->post('https://www.textguru.in/api/v22.0/', [
            'username' => $username,
            'password' => $password,
            'source' => $header,
            'dmobile' => '91' . $mobile,
            'dlttempid' => $templateId,
            'message' => $message,
        ]);

        if ($response->successful()) {
            return back()->with('otp_sent_success', 'OTP sent successfully!');
        } else {
            return back()->with('otp_sent_error', 'Failed to send OTP. Please try again.');
        }
    }


    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required']);

        $enteredOtp = $request->otp;
        $storedOtp = Session::get('otp');
        $mobile = Session::get('mobile');

        if ($enteredOtp == $storedOtp && $mobile) {
            // $feedback = Feedback::where('mobile', $mobile)->latest()->first();
            // if ($feedback) {
            //     $feedback->update(['is_verified' => true]);
            // }
            Session::put('is_verified', true);

            Session::flash('otp_verify_success', 'OTP Verified!');
        } else {
            Session::flash('otp_verify_error', 'Invalid OTP. Please try again.');
        }

        return back();
    }
}
