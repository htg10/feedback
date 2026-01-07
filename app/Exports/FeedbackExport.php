<?php
namespace App\Exports;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class FeedbackExport implements FromCollection, WithHeadings
{
    protected $feedbacks;

    public function __construct($feedbacks)
    {
        $this->feedbacks = $feedbacks;
    }

    public function collection()
    {
        return $this->feedbacks->map(function ($f) {
            return [
                'Unique ID' => $f->unique_id,
                'Name' => $f->name,
                'Mobile' => $f->mobile,
                'Room' => $f->rooms->name ?? '-',
                'Building' => $f->rooms->buildings->name ?? '-',
                'Rating %' => $f->rating,
                'Remark' => $f->comments ?? '-',
                'Created At' => $f->created_at->format('d M Y'),
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
            'Building',
            'Rating %',
            'Remark',
            'Created At',
        ];
    }
}
