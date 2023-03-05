<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\UserRequest;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends ApiController
{
    public function __construct(
        public UserInterface $user_repository,
    ) {
    }

    public function register(UserRequest $request): JsonResponse
    {
        $res = $this->user_repository->register($request->validated());

        return $res ? $this->withSuccess() : $this->withError();
    }

    public function login(LoginRequest $request): JsonResponse
    {
        return $this->user_repository->login($request->validated());
    }

    public function logout(): JsonResponse
    {
        return $this->user_repository->logout();
    }

    public function refresh()
    {
        return $this->user_repository->refresh();
    }
}
