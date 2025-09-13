<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Country extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'code',
        'name',
    ];

    public function companies()
    {
        return $this->hasMany(Company::class, 'country', 'id');
    }
}
