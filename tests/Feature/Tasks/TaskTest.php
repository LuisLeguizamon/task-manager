<?php

namespace Tests\Feature\Tasks;

use App\Models\Task;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{

    public function test_tasks_screen_can_be_rendered(): void
    {
        $response = $this->get('/tasks');

        $response->assertStatus(200);
    }

    public function test_tasks_can_be_created(): void
    {
        $form = ['name' => 'Task Test'];

        $response = $this->post(route('tasks.store', $form));

        $response->assertStatus(200);

        $newTask = Task::where('name', $form['name']);

        $this->assertTrue($newTask->exists());
    }

    public function test_tasks_can_be_updated(): void
    {
        $task = new Task;
        $task->name = 'Task Test';
        $task->priority = 1;
        $task->save();

        $url = route('tasks.update', $task->id);

        $editForm = ['name' => 'Task Test Edit'];

        $this->put($url, $editForm);

        $task->refresh();

        $this->assertTrue($task->name == 'Task Test Edit');
    }

    public function test_tasks_can_be_deleted(): void
    {
        $task = new Task;
        $task->name = 'Task Test';
        $task->priority = 1;
        $task->save();

        $url = route('tasks.destroy', $task->id);
        $this->delete($url);

        $this->assertFalse(Task::where('name', 'Task Test')->where('priority', 1)->exists());
    }
}
