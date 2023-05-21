<?php

namespace App\Services\Task;

use App\Models\Task;

class UpdateTask
{
    public function execute(array $validated, Task $task): void
    {
        $task->name = $validated['name'];
        $task->save();
    }
}