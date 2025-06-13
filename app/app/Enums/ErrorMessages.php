<?php

namespace App\Enums;

enum ErrorMessages: string
{
    case USER_NOT_FOUND = 'User not found';

    case TASK_NOT_FOUND = 'Task not found';

    case USER_NOT_WORKING = 'User is not in working state';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
