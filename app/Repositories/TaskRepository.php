<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Models\Todo\Task;
use App\Interfaces\TaskInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class TaskRepository implements TaskInterface
{
    public function store($data): bool
    {
        try {
            $task = new Task();
            $task->name = $data['name'];
            $task->todo_list_id = $data['todo_list_id'];
            $task->status = TaskStatus::INCOMPLETE;
            $task->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function lists($data)
    {
        return Task::where('todo_list_id', $data['list_id'])->orderBy('id', 'DESC')->paginate(10);
    }

    public function deleteTask($id): bool
    {
        try {
            $task = Task::where('id', $id)->first();
            DB::beginTransaction();
            if ($task != null) {
                $task->delete();
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
            return false;
        }
    }
}
