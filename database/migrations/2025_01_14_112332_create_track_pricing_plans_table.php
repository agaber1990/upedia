<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('track_pricing_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('track_id');
            $table->integer('pricing_plan_type_id');
            $table->integer('track_type_id');
            $table->decimal('price', 8, 2);
            $table->timestamps();
        });
    }   

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_pricing_plans');
    }
};
