<?php

namespace App\Services;

use App\Interfaces\UserServiceInterface;
use App\Models\User;
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

    public function getAll()
    {
        return User::all(['_id','name','email']);
    }

    public function create(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function find(string $id)
    {
        return User::find($id, ['_id','name','email']);
    }

    public function update(string $id, array $data)
    {
        $user = User::find($id);
        if (!$user) return null;

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function delete(string $id)
    {
        $user = User::find($id);
        if (!$user) return false;

        $user->delete();
        return true;
    }

}
