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
            // $table->json('slot_id');  // Change this from unsignedBigInteger to json type
            $table->text('course_name_en');
            $table->text('course_name_ar');
            $table->string('status');
            $table->integer('session');
            $table->string('schedule');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('staff_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('track_level_id');
            $table->unsignedBigInteger('track_type_id');
            $table->unsignedBigInteger('track_id');
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
