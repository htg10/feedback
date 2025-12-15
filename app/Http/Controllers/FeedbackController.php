<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{

    public function submit(Request $request)
    {
        $request->validate([
            'type' => 'required|in:feedback,complaint',
            'mobile' => 'required|digits:10',
            'document.*' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
        ]);

        // Check session verification
        $sessionMobile = Session::get('mobile');
        $isVerified = Session::get('is_verified');

        if (!$isVerified || $request->mobile !== $sessionMobile) {
            return back()->with('error', 'Please verify your OTP before submitting.');
        }
        // dd($request->all());
        // Create a new feedback entry (now only after OTP verification)
        // $filePath = null;
        // if ($request->hasFile('document')) {
        //     $file = $request->file('document');
        //     $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        //     $file->storeAs('documents', $fileName, 'public');
        //     $filePath = 'storage/documents/' . $fileName;
        // }

        $documentPaths = [];
        if ($request->hasFile('document')) {
            foreach ($request->file('document') as $file) {
                if ($file->isValid()) {
                    $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->storeAs('documents', $fileName, 'public');
                    $documentPaths[] = 'storage/documents/' . $fileName;
                }
            }
        }
        $uniqueId = 'RAIL-' . strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 5));
        // dd($uniqueId);

        if ($request->type === 'feedback') {

            // Define weight mapping based on form keys
            $weights = [
                'food_quality' => 10,
                'hygiene_services' => 10,
                'ambience' => 5,
                'suit_condition' => 10,
                'bathroom_utilities' => 10,
                'housekeeping_service' => 10,
                'surroundings_cleanliness' => 10,
                'common_area_cleanliness' => 10,
                'dustbin_condition' => 10,
                'frequency_availability' => 5,
                'responsiveness' => 10,
            ];

            $feedbackData = $request->input('feedback_data', []);

            // Ensure all keys exist and cast values
            $totalScore = 0;
            $totalWeight = 0;

            foreach ($weights as $key => $weight) {
                $score = isset($feedbackData[$key]) ? (int) $feedbackData[$key] : 0;
                $totalScore += $score * $weight;
                $totalWeight += $weight;
            }

            $percentageScore = ($totalScore / ($totalWeight * 3)) * 100;
            if ($percentageScore >= 85) {
                $ratingLabel = 'Excellent';
            } elseif ($percentageScore >= 70) {
                $ratingLabel = 'Good';
            } elseif ($percentageScore >= 50) {
                $ratingLabel = 'Average';
            } else {
                $ratingLabel = 'Poor';
            }
            // $averageRating = collect($feedbackData)->avg();

            Feedback::create([
                'unique_id' => $uniqueId,
                'mobile' => $request->mobile,
                'type' => 'feedback',
                'name' => $request->name,
                'room' => $request->room,
                'feedback_data' => $feedbackData,
                'rating' => $percentageScore, // this is out of 100
                'rating_label' => $ratingLabel,
                'comments' => $request->comments,
                'document' => $documentPaths,
                'is_verified' => true,
            ]);

        } else {
            Feedback::create([
                'unique_id' => $uniqueId,
                'mobile' => $request->mobile,
                'type' => 'complaint',
                'complaint_type' => $request->complaint_type,
                'complaint_details' => $request->complaint_details,
                'room' => $request->room,
                'name' => $request->name,
                'document' => $documentPaths,
                'is_verified' => true,
            ]);
        }

        // Clear OTP session after successful submission
        Session::forget(['otp', 'mobile', 'is_verified']);
        $typeText = $request->has('complaint_type') ? 'Complaint' : 'Feedback';

        return back()->with('success', "Thank you {$request->name}! Your {$typeText} has been successfully submitted. Reference ID: <strong>{$uniqueId}</strong>");
    }
}
