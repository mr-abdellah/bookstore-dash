<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('discounts', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('code')->unique();
            $table->unsignedTinyInteger('percent');
            $table->date('starts_at')->nullable();
            $table->date('ends_at')->nullable();
            $table->boolean('active')->default(true);

            $table->uuid('publishing_house_id')->nullable()->index();
            $table->foreign('publishing_house_id')->references('id')->on('publishing_houses')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
