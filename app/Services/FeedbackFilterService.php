<?php

namespace App\Services;
use Illuminate\Http\Request;
use App\Models\Feedback;
class FeedbackFilterService
{
    public static function apply(Request $request)
    {
        $query = Feedback::where('type', 'feedback');

        // Date range (priority)
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $query->whereBetween('created_at', [
                $request->from_date . ' 00:00:00',
                $request->to_date . ' 23:59:59'
            ]);
        }

        // Building filter
        if ($request->filled('building_id')) {
            $query->whereHas('rooms.buildings', function ($q) use ($request) {
                $q->where('id', $request->building_id);
            });
        }

        return $query->with([
            'rooms.floors',
            'rooms.buildings'
        ])->latest();
    }
}
