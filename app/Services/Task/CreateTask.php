<?php

namespace App\Services\Task;

use App\Helpers\TaskHelper;
use App\Models\Task;

class CreateTask
{
    public function execute(array $validated): void
    {
        $task = new Task();
        $task->name = $validated['name'];
        $task->priority = 0;
        $task->save();
        TaskHelper::sortTasks();
    }
}
