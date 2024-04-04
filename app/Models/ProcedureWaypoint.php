<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcedureWaypoint extends Model
{
    use HasFactory;

    protected $table = 'procedure_waypoints';

    protected $fillable = [
        'step_no',
        'instructions',
        'procedure_id',
        'building_id'
    ];

    public function procedure()
    {
        return $this->belongsTo(Procedure::class, 'procedure_id');
    }
    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
