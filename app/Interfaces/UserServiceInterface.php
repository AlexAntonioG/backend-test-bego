<?php

namespace App\Interfaces;

interface UserServiceInterface
{
    public function register(array $data);
    public function login(array $credentialsData);
}
