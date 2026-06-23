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
        Schema::create('logistics_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('logistics_management_id')->nullable()->constrained('logistics_management')->cascadeOnDelete();
            $table->string('department')->nullable();
            $table->unsignedInteger('quantity')->nullable();
            $table->date('date')->nullable();
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
        Schema::dropIfExists('logistics_distributions');
    }
};
