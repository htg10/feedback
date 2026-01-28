<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Department;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReceptionController extends Controller
{
    public function feedbacks(Request $request)
    {
        $reception = Auth::user();
        if ($reception->role_id != 3) {
            abort(403, 'Unauthorized');
        }
        $buildingId = $reception->departments->building_id;

        $query = Feedback::where('type', 'feedback')
            ->whereHas('rooms', function ($q) use ($buildingId) {
                $q->where('building_id', $buildingId);
            });

        // Filter by custom date range (takes priority)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Load related data
        $feedbacks = $query->with(['rooms.floors', 'rooms.buildings'])
            ->latest()
            ->get();

        $averageRating = (clone $query)
            ->whereNotNull('rating')
            ->avg('rating');

        $averageRating = $averageRating !== null
            ? round($averageRating, 2)
            : null;

        return view('reception.feedback.index', compact('feedbacks', 'averageRating'));
    }

    public function complaints(Request $request)
    {

        $reception = Auth::user();

        if ($reception->role_id != 3) {
            abort(403, 'Unauthorized');
        }
        $buildingId = $reception->departments->building_id;

        // department
        $allowedDepartments = ['Cafeteria', 'Reception', 'Security', 'Electrical'];

        $query = Feedback::where('type', 'complaint')
            ->whereHas('rooms', function ($q) use ($buildingId) {
                $q->where('building_id', $buildingId);
            })
            ->whereHas('user.departments', function ($q) use ($allowedDepartments) {
                $q->whereIn('name', $allowedDepartments);
            });

        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('department_id')) {
            $query->whereHas('user.departments', function ($q) use ($request) {
                $q->where('id', $request->department_id);
            });
        }

        $complaints = $query->with(['rooms.floors', 'rooms.buildings', 'user.departments'])
            ->orderBy('created_at', 'DESC')
            ->get();

        $departments = Department::where('building_id', $buildingId)
            ->whereIn('name', $allowedDepartments)
            ->orderBy('name')
            ->get();

        return view('reception.complaint.index', compact('complaints', 'departments'));
    }
}
