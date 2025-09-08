<?php

namespace App\Interfaces;

interface OrderServiceInterface
{
    public function updateStatus(string $id, string $status);
    public function getAll();
    public function create(array $data);
    public function find(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}
