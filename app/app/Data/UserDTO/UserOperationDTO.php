<?php

namespace App\Data\UserDTO;

use App\Data\BaseDTO\BaseDTO;
use Illuminate\Support\Collection;

class UserOperationDTO extends BaseDTO
{
    public function __construct(
        public int        $id,
        public string     $name,
        public string     $email,
        public string     $state,
        public Collection $user_roles,
    ) {
        parent::__construct();
    }

    /**
     * @return array<string, array<int, string>>
     */
    public static function rules(): array
    {
        return [
            'email' => ['email'],
        ];
    }
}
