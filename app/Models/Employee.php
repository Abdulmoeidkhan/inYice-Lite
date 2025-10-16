<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Employee extends Model
{
    use HasFactory;

    protected $hidden = [
        'id',
    ];

    protected $fillable = [
        'uuid',
        'user_uuid',
        'designation',
        'wage',
        'study',
        'remarks',
    ];

    protected static function booted()
    {
        static::creating(function ($employee) {
            $employee->uuid = (string) Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_uuid', 'uuid');
    }
}
