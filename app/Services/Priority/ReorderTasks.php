<?php

namespace App\Services\Priority;

use App\Models\Task;

class ReorderTasks
{
    public function above(int $indexDroppedElement, int $taskPriority): void
    {
        $tasksAbove = Task::where('priority', '>=', $indexDroppedElement)
                          ->where('priority', '<', $taskPriority)
                          ->get();

        foreach ($tasksAbove as $task) {
            $task->priority = $task->priority + 1;
            $task->save();
        }
    }

    public function below(int $indexDroppedElement, int $taskPriority): void
    {
        $tasksAbove = Task::where('priority', '>', $taskPriority)
                          ->where('priority', '<=', $indexDroppedElement)
                          ->get();

        foreach ($tasksAbove as $task) {
            $task->priority = $task->priority - 1;
            $task->save();
        }
    }
}