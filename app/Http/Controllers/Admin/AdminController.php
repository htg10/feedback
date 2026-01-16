<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use App\Models\Feedback;
use App\Services\FeedbackFilterService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Review;
use App\Models\Department;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use App\Exports\FeedbackExport;
use App\Exports\ComplaintsExport;
use App\Services\ComplaintFilterService;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function exportExcel(Request $request)
    {
        // return Excel::download(new FeedbackExport, 'feedback-report.xlsx');
        $feedbacks = FeedbackFilterService::apply($request)->get();
        return Excel::download(
            new FeedbackExport($feedbacks),
            'feedback-report-' . now()->format('d-m-Y') . '.xlsx'
        );
    }

    public function exportPDF(Request $request)
    {
        // $feedbacks = Feedback::where('type', 'feedback')->get();
        $feedbacks = FeedbackFilterService::apply($request)->get();
        $pdf = Pdf::loadView('pdf.feedback.pdf', compact('feedbacks'))->setPaper('A4', 'landscape');
        return $pdf->download('feedback-report-' . now()->format('d-m-Y') . '.pdf');
    }

    public function moveFeedbacks(Request $request)
    {
        // DEBUG (temporary)
        // dd($request->all());

        $request->validate([
            'feedback_ids' => 'required|array',
            'move_to' => 'required|in:effective,exclude'
        ]);

        Feedback::whereIn('id', $request->feedback_ids)
            ->update(['list_type' => $request->move_to]);

        return back()->with('success', 'Feedbacks moved successfully');
    }


    public function feedbacks(Request $request)
    {
        $listType = $request->get('list_type', 'effective');
        $query = Feedback::where('type', 'feedback')->where('list_type', $listType);

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

        // ✅ BUILDING FILTER (NEW)
        if ($request->filled('building_id')) {
            $query->whereHas('rooms.buildings', function ($q) use ($request) {
                $q->where('id', $request->building_id);
            });
        }

        // Load related data
        $feedbacks = $query->with(['rooms.floors', 'rooms.buildings'])
            ->latest()
            ->get();

        // $averageRating = $feedbacks->count() > 0 ? $feedbacks->avg('rating') : 0;
        $averageRating = (clone $query)
            ->whereNotNull('rating')
            ->avg('rating');

        $averageRating = $averageRating !== null
            ? round($averageRating, 2)
            : null;

        $buildings = Building::orderBy('name')->get();

        return view('admin.feedback.index', compact('feedbacks', 'averageRating', 'buildings', 'listType'));
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

        if ($request->filled('month') && !$request->filled('year')) {
            $query->whereMonth('created_at', $request->month);
        }

        if ($request->filled('year') && !$request->filled('month')) {
            $query->whereYear('created_at', $request->year);
        }

        if ($request->filled('month') && $request->filled('year')) {
            $query->whereMonth('created_at', $request->month)
                ->whereYear('created_at', $request->year);
        }

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

        $complaints = $query->with(['rooms.floors', 'rooms.buildings', 'user.departments'])
            ->latest()
            ->get();

        $departments = Department::orderBy('name')->get();
        $buildings = Building::orderBy('name')->get();

        return view('admin.complaint.index', compact('complaints', 'departments', 'buildings'));
    }

    public function exportExcel1(Request $request)
    {
        $complaints = ComplaintFilterService::apply($request)->get();

        return Excel::download(
            new ComplaintsExport($complaints),
            'complaints_' . now()->format('d-m-Y') . '.xlsx'
        );
    }

    public function exportPdf1(Request $request)
    {
        $complaints = ComplaintFilterService::apply($request)->get();

        $pdf = PDF::loadView('pdf.complaint.export-pdf', compact('complaints'))
            ->setPaper('A4', 'landscape');

        return $pdf->download('complaints_' . now()->format('d-m-Y') . '.pdf');
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
