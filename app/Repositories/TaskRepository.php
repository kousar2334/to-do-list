<?php

namespace App\Repositories;

use App\Enums\TaskStatus;
use App\Models\Todo\Task;
use App\Interfaces\TaskInterface;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

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

    public function lists($data): Collection
    {
        return Task::where('todo_list_id', $data['list_id'])->orderBy('id', 'DESC')->get();
    }

    public function update($data): bool
    {
        try {
            DB::beginTransaction();
            $task = Task::where('id', $data['id'])->first();
            if ($task != null) {
                $task->name = $data['name'];
                $task->save();
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function changeStatus($id): bool
    {
        try {
            DB::beginTransaction();
            $task = Task::where('id', $id)->first();
            if ($task != null) {
                $task->status = $task->status == TaskStatus::COMPLETE ? TaskStatus::INCOMPLETE : TaskStatus::COMPLETE;
                $task->save();
                DB::commit();
                return true;
            }
            DB::rollBack();
            return false;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
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
        }
    }
}
