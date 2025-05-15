<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('authors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->text('bio')->nullable();
            $table->string('avatar')->nullable();

            $table->uuid('publishing_house_id')->nullable()->index();
            $table->foreign('publishing_house_id')->references('id')->on('publishing_houses')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('authors');
    }
};
