<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;
use Illuminate\Http\JsonResponse;
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

    public function login($data)
    {
        try {
            $token = auth('jwt-auth')->attempt($data);
            if (!$token) {
                return response()->json(
                    [
                        'success' => false,
                        'message' => 'Invalid credential'
                    ]
                );
            }
            return $this->createNewToken($token, true);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Something went wrong'
                ]
            );
        } catch (\Error $e) {
            return response()->json(
                [
                    'success' => false,
                    'message' => 'Something went wrong'
                ]
            );
        }
    }

    public function logout(): JsonResponse
    {
        try {
            auth('jwt-auth')->logout();
            return response()->json(
                [
                    'success' => true
                ]
            );
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false
                ]
            );
        }
    }

    public function refresh()
    {
        try {
            if (auth('jwt-auth')->user()) {
                return $this->createNewToken(null, false);
            }
            return $this->createNewToken(auth('jwt-auth')->refresh(), true);
        } catch (\Exception $e) {
            return response()->json(
                [
                    'success' => false,
                ]
            );
        }
    }

    protected function createNewToken($token, $token_refresh)
    {

        return response()->json([
            'success' => true,
            'access_token' => $token,
            'token_refresh' => $token_refresh,
            'user' => auth('jwt-auth')->user(),
        ]);
    }
}
