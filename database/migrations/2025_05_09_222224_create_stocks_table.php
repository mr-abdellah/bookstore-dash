<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('stocks', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('book_id')->unique()->index();
            $table->unsignedInteger('quantity')->default(0);
            $table->timestamps();

            $table->foreign('book_id')->references('id')->on('books')->cascadeOnDelete();

            $table->uuid('publishing_house_id')->nullable()->index();
            $table->foreign('publishing_house_id')->references('id')->on('publishing_houses')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
