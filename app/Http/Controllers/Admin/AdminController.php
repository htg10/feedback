<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;

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

        // Calculate average rating
        $averageRating = $feedbacks->avg('rating');

        return view('admin.feedback.index', compact('feedbacks', 'averageRating'));
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

        // Load related models
        $complaints = $query->with(['rooms.floors', 'rooms.buildings', 'user.departments'])
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.complaint.index', compact('complaints'));
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
