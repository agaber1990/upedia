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
        Schema::create('session_assignments', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id');
            $table->integer('level_id');
            $table->string('title');
            $table->string('marks');
            $table->string('min_percentage');
            $table->string('attachment');
            $table->date('submit_date');
            $table->string('description');
            $table->enum('privacy', ['locked', 'unlocked']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_assignments');
    }
};
