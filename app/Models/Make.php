<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Make extends Model
{
    use HasFactory, SoftDeletes; // Include SoftDeletes trait for soft deletes

    protected $table = 'make'; 

    protected $fillable = ['name'];


    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
