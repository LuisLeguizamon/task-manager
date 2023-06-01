<?php

namespace App\Helpers;

use App\Models\Task;

class TaskHelper
{
    public static function sortTasks()
    {
        $tasks = Task::where('completed', false)->get()->sortBy('priority');
        $i = 1;
        foreach ($tasks as $task) {
            $task->priority = $i;
            $task->save();
            $i++;
        }
    }
}