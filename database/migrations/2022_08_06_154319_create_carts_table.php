<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();

            $table->string('status'); // pending/checked-out/completed/abandone
            $table->string('coupon')->nullable();

            $table->unsignedBigInteger('total')->nullable()->default(0);
            $table->unsignedBigInteger('reduction')->nullable()->default(0);

            $table->foreignId('user_id')->index()->nullable()->constrained()->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};
