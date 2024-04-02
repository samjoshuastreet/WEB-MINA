<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingBoundary extends Model
{
    use HasFactory;

    protected $table = 'building_boundaries';

    protected $fillable = [
        'corners',
        'building_id'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
