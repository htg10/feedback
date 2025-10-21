<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.index');
    }

    public function listUsers(Request $request)
    {
        $name = $request->input('name');

        $users = User::where('role_id', 2)
            ->when($name, function ($query) use ($name) {
                $query->where('name', 'like', '%' . $name . '%');
            })->paginate(10);

        // $users = User::where('role_id', 2)->get();
        return view('admin.user.index', compact('users'));
    }

    public function delete($id)
    {
        $review = User::find($id);
        $review->delete();
    }

    public function feedbacks(Request $request)
    {
        $query = Feedback::where('type', 'feedback');

        // Filter by month only
        if ($request->filled('month') && !$request->filled('year')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter by year only
        if ($request->filled('year') && !$request->filled('month')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by both month and year
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $request->year);
        }

        // Filter by custom date range (takes priority)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Load related data
        $feedbacks = $query->with(['rooms.floors', 'rooms.buildings'])
            ->orderBy('created_at', 'desc')
            ->get();
        dd($feedbacks);
        // Calculate average rating
        $averageRating = $feedbacks->avg('rating');

        return view('admin.feedback.index', compact('feedbacks', 'averageRating'));
    }

    public function downloadDocuments($id)
    {
        $feedback = Feedback::findOrFail($id);

        // Safely handle array or JSON string
        $documents = is_array($feedback->document)
            ? $feedback->document
            : (json_decode($feedback->document, true) ?? []);

        if (count($documents) === 0) {
            return back()->with('error', 'No documents found.');
        }

        // Prepare safe filename details
        $safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', $feedback->name ?? 'feedback');
        $date = $feedback->created_at->format('Y-m-d');

        // Single image → direct download
        if (count($documents) === 1) {
            $path = $documents[0];
            $fileName = "{$safeName}_{$date}." . pathinfo($path, PATHINFO_EXTENSION);
            return response()->download(storage_path('app/public/' . str_replace('storage/', '', $path)), $fileName);
        }

        // Multiple images → ZIP file
        $zipFileName = "{$safeName}_{$date}_documents.zip";
        $zipPath = storage_path("app/public/{$zipFileName}");

        $zip = new ZipArchive;
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            foreach ($documents as $file) {
                $filePath = storage_path('app/public/' . str_replace('storage/', '', $file));
                if (file_exists($filePath)) {
                    $zip->addFile($filePath, basename($filePath));
                }
            }
            $zip->close();
        }

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function complaints(Request $request)
    {
        $query = Feedback::where('type', 'complaint');

        // Filter by month only
        if ($request->filled('month') && !$request->filled('year')) {
            $query->whereMonth('created_at', $request->month);
        }

        // Filter by year only
        if ($request->filled('year') && !$request->filled('month')) {
            $query->whereYear('created_at', $request->year);
        }

        // Filter by both month and year
        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $request->year);
        }

        // Filter by custom date range
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // ✅ Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // ✅ Department filter (joins through user relationship)
        if ($request->filled('department_id')) {
            $query->whereHas('user.departments', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        // Load related models
        $complaints = $query->with(['rooms.floors', 'rooms.buildings', 'user.departments'])
            ->orderBy('created_at', 'desc')
            ->get();

        // 🔥 Pass departments to the view
        $departments = Department::all();

        return view('admin.complaint.index', compact('complaints', 'departments'));
    }

    public function statusToggle(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        $complaint = Feedback::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        return redirect('/admin/complaints')->with('success', 'Complaint status updated successfully.');
    }
}
