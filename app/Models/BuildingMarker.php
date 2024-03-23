<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingMarker extends Model
{
    use HasFactory;

    protected $table = 'building_markers';

    protected $fillable = [
        'markers',
        'marker_image',
        'building_id'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
