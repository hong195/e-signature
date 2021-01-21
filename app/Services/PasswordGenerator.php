<?php


namespace App\Services;


use Illuminate\Support\Str;

class PasswordGenerator
{
    public function generate(): string
    {
        return Str::random(8);
    }
}
