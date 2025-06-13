<?php

namespace App\Data\AssignUserDTO;

use App\Data\BaseDTO\BaseDTO;

class TaskUserDTO extends BaseDTO
{
    public function __construct(
        public string $user_id
    ) {
        parent::__construct();
    }

    public static function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
        ];
    }
}
