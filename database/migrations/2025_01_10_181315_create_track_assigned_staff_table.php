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
        Schema::create('track_assigned_staff', function (Blueprint $table) {
            $table->id();
            $table->integer('staff_id');
            $table->integer('category_id');
            $table->string('track_type_id');
            $table->integer('track_id');
            $table->string('levels')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('track_assigned_staff');
    }
};
