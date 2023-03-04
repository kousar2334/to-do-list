<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Support\Facades\Hash;

class UserRepository implements UserInterface
{

    public function register($data): bool
    {
        try {
            $user = new User();
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->password = Hash::make($data['password']);
            $user->save();
            return true;
        } catch (\Exception $e) {
            return false;
        } catch (\Error $e) {
            return false;
        }
    }
}
