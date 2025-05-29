<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->string('wilaya');
            $table->string('commune');
            $table->text('address');
            $table->uuid('delivery_type_id')->nullable()->index();
            $table->string('order_status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->default('offline');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();
            $table->foreign('delivery_type_id')->references('id')->on('delivery_types')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
