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
        Schema::create('monitoring_consoles', function (Blueprint $table) {
            $table->id();
            $table->string('console_name');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->foreignId('monitoring_staff_id')->nullable()->constrained()->onDelete('restrict');
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
        Schema::dropIfExists('monitoring_consoles');
    }
};
