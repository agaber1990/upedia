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
        Schema::create('staff_sepcializations', function (Blueprint $table) {
            $table->id();
            $table->string('track_id');
            $table->string('track_type_id');
            $table->string('levels');
            $table->string('cat_id');
            $table->string('staff_id');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_sepcializations');
    }
};