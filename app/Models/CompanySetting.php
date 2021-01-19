<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CompanySetting extends Model
{
    use HasFactory;

    protected $table = 'companies_settings';

    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    public function scopeToken($query)
    {
        return $query->where('name', 'yandex_token');
    }
}
