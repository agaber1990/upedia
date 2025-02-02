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
        Schema::create('staff_work_experiences', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->integer('staff_id');
            $table->string('company_name');
            $table->string('title');
            $table->string('from');
            $table->string('to');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_work_experiences');
    }
};
