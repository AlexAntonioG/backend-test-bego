<?php

namespace App\Services;

use App\Interfaces\TruckServiceInterface;
use App\Models\Truck;
use MongoDB\BSON\ObjectId;

class TruckService implements TruckServiceInterface
{
    public function getAll()
    {
        return Truck::raw(function($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'users',
                        'localField' => 'user',
                        'foreignField' => '_id',
                        'as' => 'owner'
                    ]
                ],
                ['$unwind' => '$owner'],
                [
                    '$unset' => ['owner.password']
                ]
            ]);
        });
    }

    public function create(array $data)
    {
        if (isset($data['user']) && is_string($data['user'])) {
            $data['user'] = new ObjectId($data['user']);
        }

        return Truck::create($data);
    }

    public function find(string $id)
    {
        return Truck::raw(function($collection) use ($id) {

            return $collection->aggregate([
                [
                    '$match' => [
                        '_id' => new ObjectId($id)
                    ]
                ],
                [
                    '$lookup' => [
                        'from' => 'users',
                        'localField' => 'user',
                        'foreignField' => '_id',
                        'as' => 'owner'
                    ]
                ],
                ['$unwind' => '$owner'],
                [
                    '$unset' => ['owner.password']
                ]
            ]);

        })->first();
    }

    public function update(string $id, array $data)
    {
        $truck = Truck::find($id);
        if (!$truck) return null;

        if (isset($data['user']) && is_string($data['user'])) {
            $data['user'] = new ObjectId($data['user']);
        }

        $truck->update($data);
        return $truck;
    }

    public function delete(string $id)
    {
        $truck = Truck::find($id);
        if (!$truck) return false;

        $truck->delete();
        return true;
    }
}
