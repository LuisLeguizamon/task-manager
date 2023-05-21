<?php

namespace App\Helpers;

use App\Models\Task;

class TaskHelper
{
    public static function sortTasks()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $task->priority = $task->priority + 1;
            $task->save();
        }
    }
}