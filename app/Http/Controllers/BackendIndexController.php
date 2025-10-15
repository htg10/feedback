<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Category;
use App\Models\Feedback;
use App\Models\Floor;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BackendIndexController extends Controller
{
    public function index()
    {
        $users = User::where('role_id', 2)->count();
        $buildings = Building::all()->count();
        $floors = Floor::all()->count();
        $rooms = Room::all()->count();
        $complaints = Feedback::where('type', 'complaint')
            ->count();
        $totalpendingcomplaints = Feedback::where('type', 'complaint')
            ->where('status', 'pending')
            ->count();
        $totalcompleteomplaints = Feedback::where('type', 'complaint')
            ->where('status', 'complete')
            ->count();
        $feedbacks = Feedback::where('type', 'feedback')
            ->count();
        $usercomplaints = Feedback::where('type', 'complaint')
            ->where('complaint_type', Auth::id())
            ->count();

        $pendingcomplaints = Feedback::where('type', 'complaint')
            ->where('status', 'pending')
            ->where('complaint_type', Auth::id())
            ->count();

        $resolvedcomplaints = Feedback::where('type', 'complaint')
            ->where('status', 'complete')
            ->where('complaint_type', Auth::id())
            ->count();

        if (Auth::user()->role_id == 1) {
            return view('admin.index', compact('users', 'buildings', 'floors', 'rooms', 'complaints', 'feedbacks', 'totalpendingcomplaints', 'totalcompleteomplaints'));
        } elseif (Auth::user()->role_id == 2) {
            return view('user.index', compact('usercomplaints', 'pendingcomplaints', 'resolvedcomplaints'));
        }

        return redirect()->route('login');
    }
}
