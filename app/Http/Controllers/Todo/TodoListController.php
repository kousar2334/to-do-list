<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Interfaces\TodoListInterface;
use App\Http\Controllers\ApiController;
use App\Http\Requests\List\ListRequest;
use App\Http\Resources\TodoListCollection;

class TodoListController extends ApiController
{
    public function __construct(
        public TodoListInterface $todo_repository,
    ) {
    }

    public function store(ListRequest $request): JsonResponse
    {
        return $this->todo_repository->store($request->validated()) ? $this->withSuccess() : $this->withError();
    }

    public function todoLists(Request $request)
    {
        return new TodoListCollection($this->todo_repository->lists($request));
    }
}
