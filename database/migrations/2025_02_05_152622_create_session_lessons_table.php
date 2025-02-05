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
        Schema::create('session_lessons', function (Blueprint $table) {
            $table->id();
            $table->integer('session_id');
            $table->string('name');
            $table->string('duration');
            $table->string('duration');
            $table->enum('privacy', ['locked', 'unlocked']);
            $table->enum('host_type', ['image', 'youtube', 'video', 'pdf', 'word', 'excel']);
            $table->string('hose_path');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('session_lessons');
    }
};
