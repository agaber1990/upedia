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
            $table->string('cat_id'); // Foreign key to tracks
            $table->string('track_name_en'); // Foreign key to tracks
            $table->string('track_name_ar'); // Foreign key to tracks
            $table->integer('level_number');
            $table->integer('session'); // Example: 1-10 sessions
            $table->string('schedule'); // Example: 'Once per week'
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
