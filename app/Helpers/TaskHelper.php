<?php

namespace App\Helpers;

use App\Models\Task;

class TaskHelper
{
    public static function sortTasks()
    {
        $tasks = Task::all()->sortBy('priority');
        $i = 1;
        foreach ($tasks as $task) {
            $task->priority = $i;
            $task->save();
            $i++;
        }
    }
}