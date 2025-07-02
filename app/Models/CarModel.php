<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model as BaseModel;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarModel extends BaseModel
{
    use HasFactory, SoftDeletes;

    protected $table = 'models';
    protected $fillable = ['model_name', 'truck_type', 'price', 'years', 'make_id'];

    // Define the relationship to 'Year'
    public function make()
    {
        return $this->belongsTo(Make::class);
    }

    
}
