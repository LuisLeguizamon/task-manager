<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static function getTasksOrdered()
    {
        $grouped = self::orderBy('priority', 'asc')->get()->groupBy(function(Task $task, int $key) {
            if ($task->completed) {
                return "complete";
            }
            else {
                return "incomplete";
            }
        });

        return $grouped;
    }
}
