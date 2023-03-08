<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\TaskCollection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TodoListCollection extends ResourceCollection
{
    public function toArray(Request $request)
    {
        return [
            'data' => $this->collection->map(function ($data) {
                return [
                    'id' => (int) $data->id,
                    'name' => $data->name,
                    'tasks' => new TaskCollection($data->tasks)
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }
}
