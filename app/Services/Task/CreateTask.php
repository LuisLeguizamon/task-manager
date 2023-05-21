<?php

namespace App\Services\Task;

use App\Helpers\TaskHelper;
use App\Models\Task;

class CreateTask
{
    public function execute(array $validated): void
    {
        TaskHelper::sortTasks();
        $task = new Task();
        $task->name = $validated['name'];
        $task->priority = 1;
        $task->save();
    }
}
