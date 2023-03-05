<?php

namespace App\Interfaces;

interface UserInterface
{
    public function register($data);

    public function login($data);

    public function logout();

    public function refresh();
}
