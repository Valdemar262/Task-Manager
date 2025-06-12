<?php

namespace App\Services\UserService;

use App\Data\AllUsersDTO\AllUsersDTO;
use App\Data\UserDTO\UserDTO;
use App\Data\UserDTO\UserOperationDTO;
use App\DataAdapters\UserServiceDataAdapter\UserServiceDataAdapter;
use App\Enums\ResponseMessages;
use App\Enums\ErrorMessages;
use App\Enums\RoleAndPermissionNames;
use App\Models\User;
use App\Repositories\UserRepository\UserRepository;
use App\Services\RoleAndPermissionService\RoleAndPermissionService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserService
{
    public function __construct(
        private readonly RoleAndPermissionService $roleAndPermissionService,
        private readonly UserServiceDataAdapter   $userServiceDataAdapter,
        private readonly UserRepository           $userRepository,
    ) {}

    public function allUsers(): AllUsersDTO
    {
        return $this->userServiceDataAdapter->createAllUsersDTO(
            $this->userRepository->getAll()
        );
    }

    public function showUser(User $user): UserOperationDTO
    {
        return $this->userServiceDataAdapter->createUserOperationDTO($user);
    }

    /**
     * @throws \Throwable
     */
    public function updateUser(UserOperationDTO $updateUserDTO): UserOperationDTO
    {
        try {
            $user = $this->userRepository->findById($updateUserDTO->id);
            $user->updateOrFail([
                'id' => $updateUserDTO->id,
                'name' => $updateUserDTO->name,
                'email' => $updateUserDTO->email,
                'state' => $updateUserDTO->state,
                'update_at' => now(),
            ]);

            return $this->userServiceDataAdapter->createUserOperationDTO($user);
        } catch (\Throwable $e) {
            throw new ModelNotFoundException($e->getMessage());
        }
    }

    public function deleteUser(int $id): string
    {
        if ($this->userRepository->destroy($id)) {
            return ResponseMessages::DELETE_USER_MESSAGE->value;
        }

        return ErrorMessages::USER_NOT_FOUND->value;
    }

    public function createUser(UserDTO $userDTO): User
    {
        $user = User::create($userDTO->toArray());

        $this->assignRole($user, RoleAndPermissionNames::PROGRAMMER->value);

        return $user;
    }

    /**
     * @throws \Throwable
     */
    public function assignRole(User $user, string $role): string
    {
        if (RoleAndPermissionNames::getRoles()->search($role)) {

            $this->roleAndPermissionService->assignRole($user, $role);

            $user->updateOrFail(['user_roles' => $user->getRoleNames()]);

            return ResponseMessages::ROLE_APPOINTED->value;
        }
        return ResponseMessages::ROLE_DOES_NOT_EXIST->value;
    }

    /**
     * @throws \Throwable
     */
    public function removeRole(User $user, string $role): string
    {
        if (RoleAndPermissionNames::getRoles()->search($role)) {

            $this->roleAndPermissionService->removeRole($user, $role);

            $user->updateOrFail(['user_roles' => $user->getRoleNames()]);

            return ResponseMessages::ROLE_REMOVED->value;
        }
        return ResponseMessages::ROLE_DOES_NOT_EXIST->value;
    }
}
