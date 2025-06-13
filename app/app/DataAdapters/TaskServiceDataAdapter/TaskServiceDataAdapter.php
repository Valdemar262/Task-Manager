<?php

namespace App\DataAdapters\TaskServiceDataAdapter;

use App\Data\AllTasksDTO\AllTasksDTO;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use App\Data\CreateTaskDTO\CreateTaskDTO;
use App\Data\UpdateTaskDTO\UpdateTaskDTO;
use App\Data\AssignUserDTO\TaskUserDTO;

class TaskServiceDataAdapter
{
    public function createAllTasksDTO(Collection $tasks): AllTasksDTO
    {
        return AllTasksDTO::validateAndCreate([
            'allTasks' => $tasks,
        ]);
    }

    public function createTaskDTOByRequest(Request $request): CreateTaskDTO
    {
        return $this->createTasksDTO(
            title: $request->get('title'),
            description: $request->get('description'),
            state: $request->get('state'),
        );
    }

    public function createTasksDTO(
        string $title,
        string $description,
        string $state,
    ): CreateTaskDTO{
        return CreateTaskDTO::validateAndCreate([
            'title' => $title,
            'description' => $description,
            'state' => $state,
        ]);
    }

    public function createUpdateTaskDTOByRequest(Request $request): UpdateTaskDTO
    {
        return $this->createUpdateTasksDTO(
            id: $request->get('id'),
            title: $request->get('title'),
            description: $request->get('description'),
            state: $request->get('state'),
        );
    }

    public function createUpdateTasksDTO(
        int    $id,
        string $title,
        string $description,
        string $state,
    ): UpdateTaskDTO {
        return UpdateTaskDTO::validateAndCreate([
            'id' => $id,
            'title' => $title,
            'description' => $description,
            'state' => $state,
        ]);
    }

    public function createAssignUserDTOByRequest(Request $request): TaskUserDTO
    {
        return $this->createAssignUserDTO(
            user_id: $request->get('user_id')
        );
    }

    public function createAssignUserDTO(
        $user_id,
    ): TaskUserDTO {
        return TaskUserDTO::validateAndCreate([
            'user_id' => $user_id,
        ]);
    }
}
