<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Path extends Model
{
    use HasFactory;

    protected $table = 'paths';

    protected $fillable = [
        'wp_a_lng',
        'wp_a_lat',
        'wp_a_code',
        'wp_b_lng',
        'wp_b_lat',
        'wp_b_code',
        'weight'
    ];
}
