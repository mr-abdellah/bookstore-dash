<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('author_id')->index();
            $table->uuid('category_id')->index();
            $table->uuid('publishing_house_id')->nullable()->index();
            $table->uuid('discount_id')->nullable()->index();
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->string('language')->nullable();
            $table->string('dimensions')->nullable();
            $table->integer('pages_count')->nullable();
            $table->json('images')->nullable();
            $table->timestamps();

            $table->foreign('author_id')
                ->references('id')->on('authors')
                ->cascadeOnDelete();
            $table->foreign('category_id')
                ->references('id')->on('categories')
                ->cascadeOnDelete();
            $table->foreign('publishing_house_id')
                ->references('id')->on('publishing_houses')
                ->nullOnDelete();
            $table->foreign('discount_id')
                ->references('id')->on('discounts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
