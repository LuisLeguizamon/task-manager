<?php

namespace App\Services\Priority;

use App\Models\Task;
use Illuminate\Http\Request;

class UpdatePriority
{
    public function execute(Request $request): void
    {
        $reorderArray = $request->order;
        foreach ($reorderArray as $key => $order) {
            $task = Task::find($order);
            if ($task->priority != $key) {
                $task->priority = $key;
                $task->save();
            }
        }
    }
}
