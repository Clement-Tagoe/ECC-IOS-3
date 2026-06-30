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
        Schema::create('call_staff_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_staff_id')->constrained('call_staffs')->cascadeOnDelete();
            $table->date('date');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->unique(['call_staff_id', 'date']);
            $table->index(['date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('call_staff_attendances');
    }
};
