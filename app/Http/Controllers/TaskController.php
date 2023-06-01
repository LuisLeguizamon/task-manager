<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Task;
use App\Services\Task\CreateTask;
use App\Services\Task\DeleteTask;
use App\Services\Task\UpdateTask;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Task::getTasksOrdered();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        DB::beginTransaction();
        try {
            app(CreateTask::class)->execute($request->validated());
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json(['error' => true]);
        }

        return response()->json(['error' => false]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        return response()->json(['task' => $task]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, Task $task)
    {
        app(UpdateTask::class)->execute($request->validated(), $task);

        return response()->json(['error' => false]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        DB::beginTransaction();
        try {
            app(DeleteTask::class)->execute($task);
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error($th);
            return response()->json(['error' => true]);
        }

        return response()->json(['error' => false]);
    }
}
