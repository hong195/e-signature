<?php

namespace App\Models;

use App\Observers\UserSavedObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
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
        'login',
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

    public function department() : BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    protected static function boot()
    {
        parent::boot();
        self::observe(UserSavedObserver::class);
    }

    public function generateUserPassword()
    {
        $randomInt = rand(100, 1000);
        return strtolower("{$this->name}@{$this->surname}@{$randomInt}");
    }
}
