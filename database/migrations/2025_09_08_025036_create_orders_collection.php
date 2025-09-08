<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::connection('mongodb')->create('orders', function ($collection) {
            $collection->objectId('user');
            $collection->objectId('truck');
            $collection->string('status')->default('created');
            $collection->objectId('pickup');
            $collection->objectId('dropoff');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('orders');
    }
};
