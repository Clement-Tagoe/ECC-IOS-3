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
        Schema::create('call_staff_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_staff_id')->constrained();
            $table->string('call_taker_id');
            $table->string('attendance');
            $table->string('console_id');
            $table->integer('incoming');
            $table->integer('received');
            $table->integer('unanswered');
            $table->softDeletes();
            $table->timestamps();
            $table->userstamps();
            $table->userstampSoftDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_staff_activities');
    }
};
