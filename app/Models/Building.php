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

    public function badgeColor()
    {
        switch ($this->status) {
            case 'inactive':
                return 'badge-danger';
                break;
            case 'active':
                return 'badge-success';
                break;
            default:
                return 'badge-warning';
                break;
        }
    }

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

    public function events()
    {
        return $this->hasMany(Event::class, 'building_id');
    }

    public function procedureWaypoint()
    {
        return $this->hasMany(ProcedureWaypoint::class, 'building_id');
    }

    public function entrancesCount()
    {
        $entrypoints = $this->buildingEntrypoint;
        $decoded = json_decode($entrypoints->entrypoints);
        return $decoded;
    }

    public function procedureCount()
    {
        return $this->hasMany(ProcedureWaypoint::class, 'building_id')->count();
    }

    public function offices()
    {
        return $this->hasMany(Office::class, 'building_id');
    }

    public function officeCount()
    {
        return $this->hasMany(Office::class, 'building_id')->count();
    }
}
