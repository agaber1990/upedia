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
        Schema::table('sm_leave_types', function (Blueprint $table) {
            $table->integer('max_leaves_allowed')->nullable();
            $table->integer('applicable_after_work_days')->nullable();
            $table->boolean('is_leave_without_pay')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_leave_types', function (Blueprint $table) {
            $table->dropColumn(['max_leaves_allowed', 'applicable_after_work_days', 'is_leave_without_pay']);
        });
    }
};
