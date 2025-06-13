<?php

namespace App\Services\TaskService;

use App\Data\AllTasksDTO\AllTasksDTO;
use App\Data\AssignUserDTO\TaskUserDTO;
use App\Data\CreateTaskDTO\CreateTaskDTO;
use App\Data\UpdateTaskDTO\UpdateTaskDTO;
use App\DataAdapters\TaskServiceDataAdapter\TaskServiceDataAdapter;
use App\Enums\ResponseMessages;
use App\Enums\ErrorMessages;
use App\Models\Task;
use App\Repositories\TaskRepository\TaskRepository;
use App\Repositories\UserRepository\UserRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Enums\UserState;

class TaskService
{
    public function __construct(
        private readonly TaskRepository         $taskRepository,
        private readonly TaskServiceDataAdapter $taskServiceDataAdapter,
        private readonly UserRepository         $userRepository,
    ) {}

    public function allTasks(): AllTasksDTO
    {
        return $this->taskServiceDataAdapter->createAllTasksDTO(
            $this->taskRepository->getAll()
        );
    }

    public function createTask(CreateTaskDTO $taskDTO): Task
    {
        return Task::create($taskDTO->toArray());
    }

    public function showTask(int $id): Task
    {
        return $this->taskRepository->findById($id);
    }

    public function updateTask(UpdateTaskDTO $updateTaskDTO): Task
    {
        try {
            $task = $this->taskRepository->findById($updateTaskDTO->id);

            $task->update([
                'title' => $updateTaskDTO->title,
                'description' => $updateTaskDTO->description,
                'state' => $updateTaskDTO->state,
            ]);

            return $task;
        } catch (\Throwable) {
            throw new ModelNotFoundException(ErrorMessages::TASK_NOT_FOUND->value);
        }
    }

    public function deleteTask(int $id): string
    {
        if ($this->taskRepository->destroy($id)) {

            return ResponseMessages::DELETE_TASK_SUCCESS->value;
        }

        return ErrorMessages::TASK_NOT_FOUND->value;
    }

    public function assignUser(TaskUserDTO $assignUserDTO, Task $task): Task|string
    {
        $user = $this->userRepository->findById($assignUserDTO->user_id);

        if ($user->state !== UserState::WORKING->value) {
            return ErrorMessages::USER_NOT_WORKING->value;
        }

        $task->users()->syncWithoutDetaching($user->id);

        return $this->taskRepository->loadTaskWithUsers($task);
    }

    public function unassignUser(TaskUserDTO $assignUserDTO, Task $task): Task|string
    {
        $user = $this->userRepository->findById($assignUserDTO->user_id);

        $task->users()->detach($user->id);

        return $this->taskRepository->loadTaskWithUsers($task);
    }
}
