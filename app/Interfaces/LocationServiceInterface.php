<?php

namespace App\Interfaces;

interface LocationServiceInterface
{
    public function getAll();
    public function create(array $data);
    public function find(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}
