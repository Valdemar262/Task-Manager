<?php

namespace App\Enums;

use Illuminate\Support\Collection;

enum RoleAndPermissionNames: string
{
    case PROGRAMMER = 'programmer';

    case MANAGER = 'manager';

    public static function getRoles(): Collection
    {
        return collect([
            'programmer' => self::PROGRAMMER->value,
            'manager' => self::MANAGER->value,
        ]);
    }

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
