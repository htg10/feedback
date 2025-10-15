<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Auth;

class UserController extends Controller
{
    public function complaints()
    {
        $complaints = Feedback::where('type', 'complaint')
            ->where('complaint_type', Auth::id())
            ->where('status', 'pending')
            ->get();

        return view('user.complaint.index', compact('complaints'));
    }

    public function complaintHistory()
    {
        $complaints = Feedback::where('type', 'complaint')
            ->where('complaint_type', Auth::id())
            ->where('status', 'complete')
            ->get();

        return view('user.complaint.history', compact('complaints'));
    }

    public function statusToggle(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,complete'
        ]);

        $complaint = Feedback::findOrFail($id);
        $complaint->update(['status' => $request->status]);

        return redirect('/complaint/complaints')->with('success', 'Complaint status updated successfully.');
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
