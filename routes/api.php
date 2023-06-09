<?php

use App\Http\Controllers\CompleteTaskController;
use App\Http\Controllers\PriorityTaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('tasks', TaskController::class);
Route::put('tasks/complete/{task}', CompleteTaskController::class)->name('task.complete');
Route::put('tasks/priority/{task}', PriorityTaskController::class)->name('priority.update');