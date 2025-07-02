<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logics extends Model
{
    use HasFactory;

    protected $fillable = ['recipe_id', 'parameters', 'form_id', 'name'];

    // Relationships
    public function recipe()
    {
        return $this->belongsTo(Recipe::class);
    }

    public function draftForm()
    {
        return $this->belongsTo(DraftForm::class, 'form_id');
    }
}
