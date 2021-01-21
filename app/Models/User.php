<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'department_id',
        'name',
        'surname',
        'nickname',
        'status',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'import_id' => 'integer'
    ];

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function contacts(): \Illuminate\Database\Eloquent\Relations\MorphMany
    {
        return $this->morphMany(Contact::class, 'contactable');
    }
}
