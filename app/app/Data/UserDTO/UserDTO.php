<?php

namespace App\Data\UserDTO;

use App\Data\BaseDTO\BaseDTO;

class UserDTO extends BaseDTO
{
    public function __construct(
        public string $name,
        public string $email,
        public string $password,
        public string $state,
        public array  $user_roles,
    ) {
        parent::__construct();
    }

    public static function rules(): array
    {
        return [
            'email' => ['required', 'email', 'unique:users'],
        ];
    }
}
