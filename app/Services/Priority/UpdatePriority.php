<?php

namespace App\Services\Priority;

use App\Models\Task;
use Illuminate\Http\Request;

class UpdatePriority
{
    protected $reorderTasks;

    public function __construct(ReorderTasks $reorderTasks)
    {
        $this->reorderTasks = $reorderTasks;
    }

    public function execute(Request $request, Task $task): void
    {
        $indexDroppedElement = $request->index;

        // Step1: Reorder tasks that are below or above the dropped task
        if ($indexDroppedElement > $task->priority) {
            $this->reorderTasks->below($indexDroppedElement, $task->priority);
        } elseif ($indexDroppedElement < $task->priority) {
            $this->reorderTasks->above($indexDroppedElement, $task->priority);
        }

        // Step 2: Set the new priority for the dropped task
        $task->priority = $indexDroppedElement;
        $task->save();
    }
}
