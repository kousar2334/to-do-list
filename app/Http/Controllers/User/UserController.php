<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\ApiController;
use App\Http\Requests\User\UserRequest;
use App\Interface\UserInterface;

class UserController extends ApiController
{
    public function __construct(
        public UserInterface $user_repository,
    ) {
    }

    public function register(UserRequest $request)
    {
        return $request;
    }
}
