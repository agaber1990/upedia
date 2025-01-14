<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('discount_plans', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('name_en');
            $table->string('name_ar');
            $table->json('levels_prices')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discount_plans');
    }
};
