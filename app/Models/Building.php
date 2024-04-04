<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Building extends Model
{
    use HasFactory;

    protected $table = 'buildings';

    protected $fillable = [
        'building_name',
        'status'
    ];

    public function buildingDetails()
    {
        return $this->hasOne(BuildingDetails::class, 'building_id');
    }

    public function buildingMarker()
    {
        return $this->hasOne(BuildingMarker::class, 'building_id');
    }

    public function buildingBoundary()
    {
        return $this->hasOne(BuildingBoundary::class, 'building_id');
    }

    public function buildingEntrypoint()
    {
        return $this->hasOne(BuildingEntrypoint::class, 'building_id');
    }

    public function procedures()
    {
        return $this->belongsToMany(ProcedureWaypoint::class, 'building_id');
    }

    public function procedureWaypoint()
    {
        return $this->hasOne(ProcedureWaypoint::class, 'building_id');
    }
}
