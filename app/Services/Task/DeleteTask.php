<?php

namespace App\Services\Task;

use App\Helpers\TaskHelper;
use App\Models\Task;

class DeleteTask
{
    public function execute(Task $task): void
    {
        $task->delete();
        TaskHelper::sortTasks();
    }
}