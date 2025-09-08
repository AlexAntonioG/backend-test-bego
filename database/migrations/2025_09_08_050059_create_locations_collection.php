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
        Schema::connection('mongodb')->create('locations', function ($collection) {
            $collection->string('address');
            $collection->string('place_id');
            $collection->double('latitude');
            $collection->double('longitude');
            $collection->unique('place_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('locations');
    }
};
