<?php

namespace App\Services\Priority;

use App\Models\Task;
use Illuminate\Http\Request;

class UpdatePriority
{
    public function execute(Request $request, Task $task): void
    {
        $indexDroppedElement = $request->index;

        // Step1: Reorder tasks that are below or above the dropped task
        if ($indexDroppedElement > $task->priority) {
            $this->reOrderTasksBelow($indexDroppedElement, $task->priority);
        } elseif ($indexDroppedElement < $task->priority) {
            $this->reOrderTasksAbove($indexDroppedElement, $task->priority);
        }

        // Step 2: Set the new priority for the dropped task
        $task->priority = $indexDroppedElement;
        $task->save();
    }

    private function reOrderTasksAbove($indexDroppedElement, $taskPriority): void
    {
        $tasksAbove = Task::where('priority', '>=', $indexDroppedElement)
                          ->where('priority', '<', $taskPriority)
                          ->get();

        foreach ($tasksAbove as $task) {
            $task->priority = $task->priority + 1;
            $task->save();
        }
    }

    private function reOrderTasksBelow($indexDroppedElement, $taskPriority): void
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
