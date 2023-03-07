<?php

namespace App\Http\Controllers\Todo;

use Illuminate\Http\Request;
use App\Interfaces\TaskInterface;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\TaskCollection;
use App\Http\Controllers\ApiController;
use App\Http\Requests\Task\TaskRequest;

class TaskController extends ApiController
{
    public function __construct(
        public TaskInterface $task_repository
    ) {
    }

    public function store(TaskRequest $request): JsonResponse
    {

        return $this->task_repository->store($request->validated()) ? $this->withSuccess() : $this->withError();
    }

    public function taskList(Request $request)
    {
        return new TaskCollection($this->task_repository->lists($request));
    }

    public function deleteTask(Request $request)
    {
        return $this->task_repository->deleteTask($request['id']) ? $this->withSuccess() : $this->withError();
    }
}
