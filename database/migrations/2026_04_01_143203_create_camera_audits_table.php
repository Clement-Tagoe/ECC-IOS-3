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
        Schema::create('camera_audits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('region_id')->constrained()->onDelete('restrict');
            $table->string('camera_name');
            $table->foreignId('camera_location_id')->nullable()->constrained()->onDelete('restrict');
            $table->string('status');
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
        Schema::dropIfExists('camera_audits');
    }
};
