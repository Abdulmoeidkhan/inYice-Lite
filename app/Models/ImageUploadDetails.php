<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImageUploadDetails extends Model
{
    protected $fillable = [
        'uploaded_by',
        'path',
        'related_to',
    ];

    protected $hidden = [
        'id',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'related_to', 'uuid');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by', 'uuid');
    }
}
