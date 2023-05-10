<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    public static function getTasksOrdered()
    {
        return self::orderBy('priority', 'asc')->get();
    }
}
