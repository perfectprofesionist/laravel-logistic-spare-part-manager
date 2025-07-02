<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ColorSelection extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'color_selection';

    protected $fillable = [
        'vehicle_id',
        'color_id',
        'price',
        'color_image',
    ];

    /**
     * Define the relationship with the Vehicle model
     */
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Define the relationship with the Color model
     */
    public function color()
    {
        return $this->belongsTo(Color::class);
    }
}
