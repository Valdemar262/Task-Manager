<?php

namespace App\Http\Controllers\TaskController;

use App\DataAdapters\TaskServiceDataAdapter\TaskServiceDataAdapter;
use App\Models\Task;
use App\Services\TaskService\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TaskController
{
    public function __construct(
        private readonly TaskService            $taskService,
        private readonly TaskServiceDataAdapter $taskServiceDataAdapter,
    ) {}

    public function getAllTasks(): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->allTasks()
        );
    }

    public function createTask(Request $request): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->createTask(
                $this->taskServiceDataAdapter->createTaskDTOByRequest($request)
            ));
    }

    public function showTask(int $id): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->showTask($id)
        );
    }

    public function updateTask(Request $request): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->updateTask(
                $this->taskServiceDataAdapter->createUpdateTaskDTOByRequest($request)
            )
        );
    }

    public function deleteTask(int $id): JsonResponse
    {
        return getSuccessResponse($this->taskService->deleteTask($id));
    }

    public function assignUser(Request $request, Task $task): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->assignUser(
                $this->taskServiceDataAdapter->createAssignUserDTOByRequest($request),
                $task,
            )
        );
    }

    public function unassignUser(Request $request, Task $task): JsonResponse
    {
        return getSuccessResponse(
            $this->taskService->unassignUser(
                $this->taskServiceDataAdapter->createAssignUserDTOByRequest($request),
                $task,
            )
        );
    }
}
