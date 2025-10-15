<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'building_id',
        'floor_id',
        'category_id',
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
}
