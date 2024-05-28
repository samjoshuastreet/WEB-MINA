<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
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

    public function getStatus()
    {
        $target = $this;
        $today = Carbon::today();
        $start = Carbon::parse($target->start_date)->format('F d (h:i A)');
        $end = Carbon::parse($target->end_date)->format('F d (h:i A)');
        if ($today >= $target->end_date) {
            $status = 'Ended';
        } elseif ($today < $target->end_date && $today >= $target->start_date) {
            $status = 'On Going';
        } else {
            $status = 'Upcoming';
        }
        return $status;
    }
}
