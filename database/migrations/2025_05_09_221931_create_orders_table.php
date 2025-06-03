<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('reference')->unique();
            $table->uuid('user_id')->nullable()->index();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone');
            $table->foreignId('wilaya_id')->constrained('wilayas');
            $table->foreignId('commune_id')->constrained('communes');
            $table->text('address');
            $table->string('order_status')->default('pending');
            $table->string('payment_status')->default('pending');
            $table->string('payment_method')->default('offline');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->nullOnDelete();

            $table->uuid('publishing_house_id')->nullable()->index()->after('user_id');
            $table->foreign('publishing_house_id')->references('id')->on('publishing_houses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
