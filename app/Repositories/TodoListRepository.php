<?php

namespace App\Repositories;

use App\Interfaces\TodoListInterface;
use App\Models\Todo\TodoList;

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

    public function lists($data)
    {
        return TodoList::orderBy('id', 'DESC')->paginate(10);
    }
}
