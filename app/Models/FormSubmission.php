<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class FormSubmission extends Model
{
    protected $fillable = [
        'guid', 'options', 'email', 'form_slug', 'is_submitted'
    ];

    protected $casts = [
        'summary' => 'array',
        'is_submitted' => 'boolean',
    ];
}

