<?php

namespace App\Domain\Security;

class Role
{
    public const ROLE_USER = 'ROLE_USER';
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

    public static function getAvailableRoles(): array
    {
        return [
            self::ROLE_USER => 'ROLE_USER',
            self::ROLE_ADMIN => 'ROLE_ADMIN',
            self::ROLE_SUPER_ADMIN => 'ROLE_SUPER_ADMIN',
        ];
    }
}