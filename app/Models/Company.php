<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'website',
        'yandex_connect_token',
        'logo_url',
        'color',
    ];

    public function departments() : HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function settings() : HasMany
    {
        return $this->hasMany(CompanySetting::class);
    }
}
