<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Company extends Model implements HasMedia
{
    use HasFactory;
    use HasMediaTrait;


    protected $fillable = [
        'name',
        'address',
        'website',
    ];

    public function departments() : HasMany
    {
        return $this->hasMany(Department::class);
    }

    public function settings() : HasMany
    {
        return $this->hasMany(CompanySetting::class);
    }

    public function users(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(User::class, Department::class);
    }

    public function registerMediaCollections()
    {
        $this
            ->addMediaCollection('logo')
            ->singleFile();
    }
}
