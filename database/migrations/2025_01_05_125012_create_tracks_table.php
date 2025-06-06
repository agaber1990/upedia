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
        Schema::create('tracks', function (Blueprint $table) {
            $table->id();
            $table->string('category_id'); // Foreign key to categories
            $table->string('name_en'); 
            $table->string('name_ar'); 
            $table->integer('level_number');
            $table->integer('session'); // Example: 1-10 sessions
            $table->string('schedule')->nullable(); // Example: 'Once per week'
            $table->json('valid_for'); // Example: ['private', 'group']
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracks');
    }
};
