<?php

namespace App\Services;

use App\Interfaces\OrderServiceInterface;
use App\Models\Order;
use MongoDB\BSON\ObjectId;
use Exception;

class OrderService implements OrderServiceInterface
{
    public function getAll()
    {
        return Order::raw(function($collection) {
            return $collection->aggregate([
                [
                    '$lookup' => [
                        'from' => 'users',
                        'localField' => 'user',
                        'foreignField' => '_id',
                        'as' => 'user'
                    ]
                ],
                ['$unwind' => '$user'],
                [
                    '$lookup' => [
                        'from' => 'trucks',
                        'localField' => 'truck',
                        'foreignField' => '_id',
                        'as' => 'truck'
                    ]
                ],
                ['$unwind' => '$truck'],
                [
                    '$lookup' => [
                        'from' => 'locations',
                        'localField' => 'pickup',
                        'foreignField' => '_id',
                        'as' => 'pickup'
                    ]
                ],
                ['$unwind' => '$pickup'],
                [
                    '$lookup' => [
                        'from' => 'locations',
                        'localField' => 'dropoff',
                        'foreignField' => '_id',
                        'as' => 'dropoff'
                    ]
                ],
                ['$unwind' => '$dropoff'],
                [
                    '$unset' => [
                        'user.password',
                    ]
                ]
            ]);
        });
    }

    public function create(array $data)
    {
        foreach (['user','truck','pickup','dropoff'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = new ObjectId($data[$field]);
            }
        }

        return Order::create($data);
    }

    public function find(string $id)
    {
        return Order::raw(function($collection) use ($id) {
            return $collection->aggregate([
                [
                    '$match' => ['_id' => new ObjectId($id)]
                ],
                [
                    '$lookup' => [
                        'from' => 'users',
                        'localField' => 'user',
                        'foreignField' => '_id',
                        'as' => 'user'
                    ]
                ],
                ['$unwind' => '$user'],
                [
                    '$lookup' => [
                        'from' => 'trucks',
                        'localField' => 'truck',
                        'foreignField' => '_id',
                        'as' => 'truck'
                    ]
                ],
                ['$unwind' => '$truck'],
                [
                    '$lookup' => [
                        'from' => 'locations',
                        'localField' => 'pickup',
                        'foreignField' => '_id',
                        'as' => 'pickup'
                    ]
                ],
                ['$unwind' => '$pickup'],
                [
                    '$lookup' => [
                        'from' => 'locations',
                        'localField' => 'dropoff',
                        'foreignField' => '_id',
                        'as' => 'dropoff'
                    ]
                ],
                ['$unwind' => '$dropoff'],
                [
                    '$unset' => [
                        'user.password',
                    ]
                ]
            ]);
        })->first();
    }

    public function update(string $id, array $data)
    {
        $order = Order::find($id);
        if (!$order) return null;

        foreach (['user','truck','pickup','dropoff'] as $field) {
            if (isset($data[$field]) && is_string($data[$field])) {
                $data[$field] = new ObjectId($data[$field]);
            }
        }

        $order->update($data);
        return $order;
    }

    public function delete(string $id)
    {
        $order = Order::find($id);
        if (!$order) return false;

        $order->delete();
        return true;
    }

    public function updateStatus(string $id, string $status)
    {
        if (!in_array($status, Order::$statuses)) {
            throw new Exception("Estatus no permitido");
        }

        $order = Order::find($id);
        if (!$order) return null;

        $order->update(['status' => $status]);
        return $order;
    }
}
