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
        Schema::create('monitoring_shift_reports', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('shift_type');
            $table->time('start_time');
            $table->time('end_time');
            $table->string('status');
            $table->integer('expected_attendance');
            $table->integer('present');
            $table->integer('absent');
            $table->integer('absent_with_permission');
            $table->integer('occupied_consoles');
            $table->integer('unoccupied_consoles');
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->userstampSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_shift_reports');
    }
};
