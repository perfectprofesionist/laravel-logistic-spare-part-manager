<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PublishedForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'steps',
        'logic',
        'status',
        'draft_form_id'
    ];

    protected $casts = [
        'steps' => 'array',
        'logic' => 'array'
    ];

    public function draftForm()
    {
        return $this->belongsTo(DraftForm::class);
    }
}
