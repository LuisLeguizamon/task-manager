<?php

namespace App\Services\Priority;

use App\Helpers\TaskHelper;
use App\Models\Task;
use Illuminate\Http\Request;

class UpdatePriority
{
    public function execute(Request $request, Task $task): void
    {
        $indexDroppedElement = $request->index;
        // Step1: Reorder tasks that are below the dropped task
        $this->reOrderTaskBelow($indexDroppedElement);
        // Step 2: Set the new priority for the dropped task
        $task->priority = $indexDroppedElement;
        $task->save();
        TaskHelper::sortTasks();
    }

    private function reOrderTaskBelow($indexDroppedElement): void
    {
        $taskBelow = Task::where('priority', $indexDroppedElement)->get()->first();
        $taskBelow->priority = $taskBelow->priority + 1;
        $taskBelow->save();
    }
}
