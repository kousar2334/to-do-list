<?php

namespace App\Repositories;

use App\Models\Todo\TodoList;
use Illuminate\Support\Facades\DB;
use App\Interfaces\TodoListInterface;
use Illuminate\Contracts\Pagination\Paginator;

class TodoListRepository implements TodoListInterface
{

    public function store($data): bool
    {
        try {
            $list = new TodoList();
            $list->name = $data['name'];
            $list->save();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function lists($data): Paginator
    {
        return TodoList::orderBy('id', 'DESC')->paginate(4);
    }

    public function update($data): bool
    {
        try {
            DB::beginTransaction();
            $list = TodoList::where('id', $data['id'])->first();
            if ($list != null) {
                $list->name = $data['name'];
                $list->save();
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

    public function delete($id): bool
    {
        try {
            DB::beginTransaction();
            $list = TodoList::where('id', $id)->first();
            if ($list != null) {
                $list->delete();
                DB::commit();
                return true;
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
