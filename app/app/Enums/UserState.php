<?php

namespace App\Enums;

enum UserState: string
{
    case WORKING = 'working';
    case ON_VACATION = 'on_vacation';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
