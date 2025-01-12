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
            $table->unsignedBigInteger('cat_id');
            $table->json('slot_id');  // Change this from unsignedBigInteger to json type
            $table->integer('staff_id');
            $table->integer('track_type_id');
            $table->integer('track_id');
            $table->string('status');
            $table->integer('session');
            $table->string('schedule');
            $table->date('start_date');
            $table->date('end_date');
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
