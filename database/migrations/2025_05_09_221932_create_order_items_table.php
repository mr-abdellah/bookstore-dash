<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id')->index();
            $table->uuid('book_id')->nullable()->index();
            $table->unsignedInteger('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('commission', 10, 2);
            $table->uuid('publishing_house_id')->nullable()->index();
            $table->decimal('profit_percentage', 5, 2)->nullable();
            $table->string('status')->default('pending');
            $table->foreignUuid('confirmed_by')->nullable()->constrained('users');
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->foreign('order_id')->references('id')->on('orders')->cascadeOnDelete();
            $table->foreign('book_id')->references('id')->on('books')->nullOnDelete();
            $table->foreign('publishing_house_id')->references('id')->on('publishing_houses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
