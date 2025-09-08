<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model as Eloquent;

class Location extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'locations';

    protected $fillable = ['address','place_id','latitude','longitude'];
}
