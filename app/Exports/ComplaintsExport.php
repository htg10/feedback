<?php

namespace App\Exports;

use App\Models\Feedback;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\{
    FromCollection,
    WithHeadings,
    WithMapping,
    ShouldAutoSize
};

class ComplaintsExport implements FromCollection, WithHeadings
{
    protected $complaints;

    public function __construct($complaints)
    {
        $this->complaints = $complaints;
    }

    public function collection()
    {
        return $this->complaints->map(function ($c) {
            return [
                'Unique ID' => $c->unique_id,
                'Name' => $c->name,
                'Mobile' => $c->mobile,
                'Room' => $c->rooms->name ?? '-',
                'Department' => $c->user->departments->name ?? '-',
                'Status' => ucfirst($c->status),
                'Created At' => $c->created_at->format('d M Y'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Unique ID',
            'Name',
            'Mobile',
            'Room',
            'Department',
            'Status',
            'Created At',
        ];
    }
}
