<?php

namespace App\Entity;


class UserRole
{
    public const USER = 'ROLE_USER';
    public const ADMIN = 'ROLE_ADMIN';

    public static function All(): array
    {
        return [
            self::USER,
            self::ADMIN
        ];
    }
}