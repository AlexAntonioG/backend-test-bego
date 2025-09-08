<?php

namespace App\Interfaces;

interface UserServiceInterface
{
    public function register(array $data);
    public function login(array $credentialsData);
    public function getAll();
    public function create(array $data);
    public function find(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}
