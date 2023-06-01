<?php

namespace App\Services\Task;

use App\Helpers\TaskHelper;
use App\Models\Task;

class CompleteTask
{
    /*  Mark a task like complete or incomplete.
        If task is already completed, set it like incompleted and vice versa
    */
    public function execute(Task $task): void
    {
        $task->completed = !$task->completed;
        $task->save();
        TaskHelper::sortTasks();
    }
}