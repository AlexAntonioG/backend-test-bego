<?php

namespace App\Services;

use App\Interfaces\LocationServiceInterface;
use App\Models\Location;

class LocationService implements LocationServiceInterface
{
    public function getAll()
    {
        return Location::all();
    }

    public function create(array $data)
    {
        // Evitar duplicados por place_id
        if (Location::where('place_id', $data['place_id'])->exists()) {
            return Location::where('place_id', $data['place_id'])->first();
        }

        return Location::create($data);
    }

    public function find(string $id)
    {
        return Location::find($id);
    }

    public function update(string $id, array $data)
    {
        $location = Location::find($id);
        if (!$location) return null;

        $location->update($data);
        return $location;
    }

    public function delete(string $id)
    {
        $location = Location::find($id);
        if (!$location) return false;

        $location->delete();
        return true;
    }
}
