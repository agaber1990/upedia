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
        Schema::create('staff_scheduleds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('slot_id'); // Reference to staff_slots table
            $table->unsignedBigInteger('staff_id'); // Reference to staff_slots table
            $table->string('courseName');
            $table->string('status'); // Can be 'scheduled', 'confirmed', etc.
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_scheduleds');
    }
};
