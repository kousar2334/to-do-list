<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserRequest;
use App\Interfaces\UserInterface;

class UserController extends ApiController
{
    public function __construct(
        public UserInterface $user_repository,
    ) {
    }

    public function register(UserRequest $request)
    {
        $res = $this->user_repository->register($request->validated());

        return $res ? $this->withSuccess() : $this->withError();
    }
}
