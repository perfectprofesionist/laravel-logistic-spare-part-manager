<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DraftForm extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'steps',
        'logic',
        'status',
        "admin_emails"
    ];

    protected $casts = [
        'steps' => 'array',
        'logic' => 'array'
    ];

    public function publishedForm()
    {
        return $this->hasOne(PublishedForm::class);
    }

    public function publish()
    {
        return PublishedForm::create([
            'name' => $this->name,
            'steps' => $this->steps,
            'logic' => $this->logic,
            'draft_form_id' => $this->id
        ]);
    }
}
