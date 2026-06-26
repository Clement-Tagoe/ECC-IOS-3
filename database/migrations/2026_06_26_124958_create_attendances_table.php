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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('call_staff_id')->constrained('call_staffs')->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['present', 'absent']);
            $table->timestamps();
            $table->softDeletes();
            $table->userstamps();
            $table->userstampSoftDeletes();
            $table->unique(['call_staff_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
