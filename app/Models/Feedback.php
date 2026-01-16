<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'unique_id',
        'mobile',
        'otp',
        'is_verified',
        'type',
        'list_type',
        'feedback_data',
        'rating',
        'rating_label',
        'comments',
        'complaint_type',
        'name',
        'room',
        'complaint_details',
        'document',
        'status',
        'user_remark',
    ];

    protected $casts = [
        'feedback_data' => 'array',
        'is_verified' => 'boolean',
        'document' => 'array',
    ];

    public function buildings()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }

    public function floors()
    {
        return $this->belongsTo(Floor::class, 'floor_id');
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room');
    }
    public function departments()
    {
        return $this->belongsTo(Department::class, 'complaint_type');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'complaint_type');
    }
}
