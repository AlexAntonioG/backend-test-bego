<?php

namespace App\Interfaces;

interface TruckServiceInterface
{
    public function getAll();
    public function create(array $data);
    public function find(string $id);
    public function update(string $id, array $data);
    public function delete(string $id);
}
