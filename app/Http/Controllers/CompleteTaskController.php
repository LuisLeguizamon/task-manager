<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\Task\CompleteTask;
use Illuminate\Http\Request;

class CompleteTaskController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function __invoke(Task $task)
    {
        app(CompleteTask::class)->execute($task);

        return response()->json(['error' => false]);
    }
}
