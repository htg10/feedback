<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class FeedbackController extends Controller
{
    // public function submit(Request $request)
    // {
    //     $request->validate([
    //         'type' => 'required|in:feedback,complaint',
    //         'mobile' => 'required|digits:10',
    //         'document' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx|max:2048',
    //     ]);

    //     $feedback = Feedback::where('mobile', $request->mobile)
    //         ->where('is_verified', true)
    //         ->latest()
    //         ->firstOrFail();

    //     if (!$feedback) {
    //         return back()->with('error', 'No verified feedback entry found for this mobile number.');
    //     }

    //     if ($request->type === 'feedback') {
    //         // Capture all feedback rating fields
    //         $feedbackData = $request->input('feedback_data', []);

    //         //calculate an average rating
    //         $averageRating = collect($feedbackData)->avg();
    //         // dd($request->all());
    //         $feedback->update([
    //             'type' => 'feedback',
    //             'name' => $request->name,
    //             'room' => $request->room,
    //             'feedback_data' => $feedbackData,
    //             'rating' => $averageRating,
    //             'comments' => $request->comments,
    //         ]);
    //     } else {
    //         $filePath = null;
    //         if ($request->hasFile('document')) {
    //             $file = $request->file('document');
    //             $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
    //             $file->storeAs('documents', $fileName, 'public'); // save to storage/app/public/documents
    //             $filePath = 'storage/documents/' . $fileName;
    //         }

    //         $feedback->update([
    //             'type' => 'complaint',
    //             'complaint_type' => $request->complaint_type,
    //             'complaint_details' => $request->complaint_details,
    //             'room' => $request->room,
    //             'name' => $request->name,
    //             'document_path' => $filePath,
    //         ]);
    //     }
    //     return back()->with('success', 'Thank you! Your response has been submitted.');
    // }

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

        // dd($documentPaths);

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

        return back()->with('success', 'Thank you! Your response has been submitted.');
    }
}
