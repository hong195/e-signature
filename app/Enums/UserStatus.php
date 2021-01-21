<?php


namespace App\Enums;


class UserStatus
{
    const ACTIVE = 'active';
    const PENDING = 'pending';
    const DISMISSED = 'dismissed';

    public static function getStatuses(): array
    {
        return [
            self::ACTIVE,
            self::PENDING,
            self::DISMISSED
        ];
    }
}
