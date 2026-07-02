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
        Schema::create('monitoring_staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('monitoring_staff_id')->constrained('monitoring_staffs')->cascadeOnDelete();
            $table->date('date');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['monitoring_staff_id', 'date']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_staff_attendances');
    }
};
