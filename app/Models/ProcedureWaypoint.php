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
}
