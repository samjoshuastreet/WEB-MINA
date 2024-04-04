<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Procedure extends Model
{
    use HasFactory;

    protected $table = 'procedures';

    protected $fillable = [
        'procedure_name',
        'procedure_description',
        'intial_instructions',
        'access_level'
    ];

    public function waypoints()
    {
        return $this->hasMany(ProcedureWaypoint::class, 'procedure_id');
    }
}
