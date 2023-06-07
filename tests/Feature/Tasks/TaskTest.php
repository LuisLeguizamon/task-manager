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
}
