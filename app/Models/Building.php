<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Building extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($building) {
            $building->slug = \Str::slug($building->name);
        });

        static::updating(function ($building) {
            $building->slug = \Str::slug($building->name);
        });
    }

    public function departments()
    {
        return $this->hasMany(Department::class);
    }
}
