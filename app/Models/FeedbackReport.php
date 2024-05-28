<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeedbackReport extends Model
{
    use HasFactory;
    protected $table = 'feedback_reports';
    protected $fillable = [
        'name',
        'message',
        'status'
    ];

    public static function inProgCount()
    {
        return self::where('status', 'In Progress')->count();
    }

    public static function pausedCount()
    {
        return self::where('status', 'Paused')->count();
    }

    public static function resolvedCount()
    {
        return self::where('status', 'Resolved')->count();
    }

    public static function newCount()
    {
        return self::where('status', 'New')->count();
    }
}
