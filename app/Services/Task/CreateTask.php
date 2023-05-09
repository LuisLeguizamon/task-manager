<?php

namespace App\Services\Task;

use App\Models\Task;

class CreateTask
{
    public function execute(array $validated): void
    {
        $task = new Task();
        $task->name = $validated['name'];
        $task->priority = $validated['priority'];
        $task->save();
    }
}
