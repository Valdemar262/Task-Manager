<?php

namespace App\Repositories\TaskRepository;

use App\Models\Task;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository
{
    public function getAll(): Collection
    {
        return Task::all();
    }

    public function findById(int $id): Task
    {
        return Task::findOrFail($id);
    }

    public function destroy(int $id): int
    {
        return Task::destroy($id);
    }

    public function loadTaskWithUsers(Task $task): Task
    {
        return $task->load('users');
    }
}
