<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    use HasFactory;

    protected $table = 'offices';

    protected $fillable = [
        'office_name',
        'description',
        'status',
        'office_image',
        'building_id'
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

    public function building()
    {
        return $this->belongsTo(Building::class, 'building_id');
    }
}
