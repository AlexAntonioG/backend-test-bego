<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Truck extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'trucks';

    protected $fillable = ['user', 'year', 'color', 'plates'];
}
