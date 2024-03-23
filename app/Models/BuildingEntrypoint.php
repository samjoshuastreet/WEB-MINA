<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuildingEntrypoint extends Model
{
    use HasFactory;

    protected $table = 'building_entrypoints';

    protected $fillable = [
        'entrypoints',
        'building_id'
    ];

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
