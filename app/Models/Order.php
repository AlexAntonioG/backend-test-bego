<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Order extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'orders';

    protected $fillable = [
        'user',
        'truck',
        'status',
        'pickup',
        'dropoff',
    ];

    const STATUS_CREATED   = 'created';
    const STATUS_IN_TRANSIT = 'in transit';
    const STATUS_COMPLETED  = 'completed';

    public static array $statuses = [
        self::STATUS_CREATED,
        self::STATUS_IN_TRANSIT,
        self::STATUS_COMPLETED,
    ];
}
