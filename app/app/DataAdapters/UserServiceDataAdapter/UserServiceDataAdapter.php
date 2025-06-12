<?php

namespace App\DataAdapters\UserServiceDataAdapter;

use App\Data\AllUsersDTO\AllUsersDTO;
use App\Data\RegisterDTO\RegisterDTO;
use App\Data\UserDTO\UserDTO;
use App\Data\UserDTO\UserOperationDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Request;
use App\Models\User;
use Illuminate\Support\Collection AS RolesCollection;

class UserServiceDataAdapter
{
    public function createUser(
        string $name,
        string $email,
        string $password,
        string $state,
        array  $userRoles,
    ): UserDTO {
        return UserDTO::validateAndCreate([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'state' => $state,
            'user_roles' => $userRoles,
        ]);
    }

    public function createUserDTOByRegisterDTO(RegisterDTO $registerDTO): UserDTO
    {
        return $this->createUser(
            name: $registerDTO->name,
            email: $registerDTO->email,
            password: $registerDTO->password,
            state: 'working',
            userRoles: ['programmer'],
        );
    }

    public function createUserOperationDTO(User $user): UserOperationDTO
    {
        return UserOperationDTO::validateAndCreate([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'state' => $user->state,
            'user_roles' => $user->roles->pluck('name'),
        ]);
    }

    public function createUserOperationDTOByRequest(Request $request): UserOperationDTO
    {
        return $this->createUserOperationDataDTO(
            id: $request->get('id'),
            name: $request->get('name'),
            email: $request->get('email'),
            state: $request->get('state'),
            userRoles: collect([$request->get('userRoles')]),
        );
    }

    public function createUserOperationDataDTO(
        int             $id,
        string          $name,
        string          $email,
        string          $state,
        RolesCollection $userRoles,
    ): UserOperationDTO {
        return UserOperationDTO::validateAndCreate([
            'id' => $id,
            'name' => $name,
            'email' => $email,
            'state' => $state,
            'user_roles' => $userRoles
        ]);
    }

    /**
     * @param Collection<int, User> $users
     */
    public function createAllUsersDTO(Collection $users): AllUsersDTO
    {
        return AllUsersDTO::validateAndCreate([
            'allUsers' => $users,
        ]);
    }
}
