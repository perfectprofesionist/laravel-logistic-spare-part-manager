<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AllForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'all_forms';

    protected $fillable = [
        'name',
        'slug',
    ];

    public function drafts()
    {
        return $this->hasMany(DraftForm::class, 'form_id');
    }

    public function publishedForms()
    {
        return $this->hasMany(PublishedForm::class, 'form_id');
    }
}
