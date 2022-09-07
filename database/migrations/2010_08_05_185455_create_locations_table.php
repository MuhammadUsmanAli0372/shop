<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('locations', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('house'); // 12334
            $table->string('street'); // Street Name
            $table->string('parish')->nullable(); // Some Village/Town
            $table->string('ward')->nullable(); // Town
            $table->string('district')->nullable(); // Greater Area
            $table->string('county'); // Pakistan
            $table->string('postcode'); // DE56
            $table->string('country'); // Pakistan

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locations');
    }
};
