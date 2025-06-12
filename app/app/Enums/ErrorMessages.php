<?php

namespace App\Enums;

enum ErrorMessages: string
{
    case USER_NOT_FOUND = 'User not found';

    case STATEMENT_NOT_FOUND = 'Statement not found';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
