<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{

    public function complaints(Request $request)
    {
        $query = Feedback::where('type', 'complaint')
            ->where('complaint_type', Auth::id());

        // ✅ STATUS FILTER (MAIN LOGIC)
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $complaints = $query
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.complaint.index', compact('complaints'));
    }
    // public function complaints()
    // {
    //     $complaints = Feedback::where('type', 'complaint')
    //         ->where('complaint_type', Auth::id())
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('user.complaint.index', compact('complaints'));
    // }

    // public function complaintPending()
    // {
    //     $complaints = Feedback::where('type', 'complaint')
    //         ->where('complaint_type', Auth::id())
    //         ->where('status', 'pending')
    //         ->orderBy('created_at', 'desc')
    //         ->get();

    //     return view('user.complaint.history', compact('complaints'));
    // }

    public function statusToggle(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        $complaint = Feedback::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        return redirect('/complaint/complaints')->with('success', 'Complaint status updated successfully.');
    }

    public function updateUserRemark(Request $request, $id)
    {
        $request->validate([
            'user_remark' => 'nullable|string|max:255',
        ]);

        $complaint = Feedback::findOrFail($id);
        $complaint->user_remark = $request->user_remark;
        $complaint->save();

        return redirect()->back()->with('success', 'Remark updated successfully.');
    }

    public function statusToggle1(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        $complaint = Feedback::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        return redirect('complaint/history')->with('success', 'Complaint status updated successfully.');
    }
}
