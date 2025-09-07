<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use Illuminate\Support\Facades\Hash;
use Tymon\JWTAuth\Facades\JWTAuth;

class UserService implements UserServiceInterface
{
    public function register(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);

        // Se crea Token de autenticación
        $token = JWTAuth::fromUser($user);

        return compact('user', 'token');
    }

    public function login(array $credentialsData)
    {
        if(!$token = JWTAuth::attempt($credentialsData)){
            return null;
        }

        return $token;
    }

}
