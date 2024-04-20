<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingType extends Model
{
    use HasFactory;

    protected $table = 'building_types';

    protected $fillable = [
        'name',
        'color'
    ];

    public function building()
    {
        return $this->belongsToMany(BuildingDetails::class, 'building_type');
    }
}
