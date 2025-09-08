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
       Schema::connection('mongodb')->create('trucks', function ($collection) {
            $collection->objectId('user');
            $collection->string('year');
            $collection->string('color');
            $collection->string('plates');
            $collection->unique('plates');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::connection('mongodb')->dropIfExists('trucks');
    }
};
