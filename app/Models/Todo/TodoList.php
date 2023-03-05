<?php

namespace App\Models\Todo;

use App\Models\Todo\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TodoList extends Model
{
    use HasFactory;

    public function tasks()
    {
        return $this->hasMany(Task::class, 'todo_list_id');
    }
}
