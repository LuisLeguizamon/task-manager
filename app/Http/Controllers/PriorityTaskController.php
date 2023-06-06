<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Services\Priority\UpdatePriority;
use Illuminate\Http\Request;

class PriorityTaskController extends Controller
{
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        app(UpdatePriority::class)->execute($request, $task);

        return ["error" => false];
    }

}
