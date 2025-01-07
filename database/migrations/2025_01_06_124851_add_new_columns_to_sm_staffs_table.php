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
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->integer('emp_type_id')->nullable()->unsigned()->after('is_saas');
            $table->integer('specialization_id')->nullable()->unsigned()->after('emp_type_id');
            $table->integer('slots_emp_id')->nullable()->unsigned()->after('specialization_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sm_staffs', function (Blueprint $table) {
            $table->dropColumn('emp_type_id');
            $table->dropColumn('specialization_id');
            $table->dropColumn('slots_emp_id');
        });
    }

};
