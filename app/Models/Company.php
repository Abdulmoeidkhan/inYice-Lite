<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_uuid',
        'name',
        'display_name',
        'email',
        'contact',
        'image',
        'industry',
        'country',
        'city',
        'address',
        'status',
        'bank_details',
        'other_details',
        'social_links',
    ];

    protected $hidden = [
        'id',
    ];

    protected $casts = [
        'social_links' => 'array',
    ];

    protected static function booted()
    {
        static::creating(function ($company) {
            $company->uuid = (string) Str::uuid(); // Generate a UUID
        });

        static::creating(function ($company) {
            $company->code = strtoupper(Str::random(2)) . str_pad(mt_rand(0, 99999999), 4, '0', STR_PAD_LEFT);
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_uuid', 'uuid');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'company_uuid', 'uuid');
    }

    public function countries()
    {
        return $this->belongsTo(Country::class, 'country', 'id');
    }
}
