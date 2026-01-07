<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Feedback;

class ComplaintFilterService
{
    public static function apply(Request $request)
    {
        $query = Feedback::where('type', 'complaint');

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

        if ($request->filled('building_id')) {
            $query->whereHas('rooms.buildings', function ($q) use ($request) {
                $q->where('id', $request->building_id);
            });
        }

        return $query->with([
            'rooms.floors',
            'rooms.buildings',
            'user.departments'
        ])->orderBy('created_at', 'desc');
    }
}
