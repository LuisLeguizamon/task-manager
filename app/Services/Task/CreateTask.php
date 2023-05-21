<?php

namespace App\Services\Task;

use App\Models\Task;

class CreateTask
{
    public function execute(array $validated): void
    {
        $this->orderTasks();

        $task = new Task();
        $task->name = $validated['name'];
        $task->priority = 1;
        $task->save();
    }

    private function orderTasks()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $task->priority = $task->priority + 1;
            $task->save();
        }
    }
}
