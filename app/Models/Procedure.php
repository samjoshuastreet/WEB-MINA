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

    public function accessLevel()
    {
        $access_level = $this->access_level;

        if ($access_level == "1") {
            return 'Guest Level';
        } elseif ($access_level == "2") {
            return 'Student Level';
        } elseif ($access_level == "3") {
            return 'Faculty Level';
        } else {
            return 'Unknown Level';
        }
    }
}
