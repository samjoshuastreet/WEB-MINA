<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $fillable = [
        'event_name',
        'event_description',
        'event_instructions',
        'access_level',
        'start_date',
        'end_date',
        'building_id'
    ];
}
