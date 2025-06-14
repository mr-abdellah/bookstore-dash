<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('publisher_payouts', function (Blueprint $table) {
            $table->id();
            $table->uuid('order_item_id');
            $table->uuid('publishing_house_id');
            $table->decimal('amount', 10, 2);
            $table->string('status')->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->timestamps();

            $table->foreign(['order_item_id'])->references('id')->on('order_items')->onDelete('cascade');
            $table->foreign(['publishing_house_id'])->references('id')->on('publishing_houses')->onDelete('cascade');
            $table->index(['publishing_house_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('publisher_payouts');
    }
};