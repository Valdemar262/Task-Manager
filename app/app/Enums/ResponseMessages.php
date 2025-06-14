<?php

namespace App\Enums;

enum ResponseMessages: string
{
    case LOG_OUT_MESSAGE = 'User logged out successfully';

    case UNAUTHORIZED_MESSAGE = 'Unauthorized';

    case DELETE_USER_MESSAGE = 'User deleted successfully';

    case ROLE_APPOINTED = 'Role assigned successfully';

    case ROLE_DOES_NOT_EXIST = 'Role does not exist';

    case ROLE_REMOVED = 'Role removed successfully';

    case DELETE_TASK_SUCCESS = 'Task deleted successfully';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}

