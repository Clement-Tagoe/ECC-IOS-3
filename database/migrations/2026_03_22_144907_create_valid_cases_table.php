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
        Schema::create('valid_cases', function (Blueprint $table) {
            $table->id();
            $table->string('case_id');
            $table->time('reporting_time');
            $table->date('reporting_date');
            $table->foreignId('region_id')->constrained()->cascadeOnDelete();
            $table->foreignId('agency_id')->nullable()->constrained()->cascadeOnDelete();
            $table->foreignId('valid_case_nature_id')->constrained()->cascadeOnDelete();
            $table->foreignId('location_id')->constrained()->cascadeOnDelete();
            $table->time('dispatched_time')->nullable();
            $table->time('agency_arrival_time')->nullable();
            $table->time('agency_response_time')->nullable();
            $table->string('status');
            $table->string('contact_name');
            $table->string('contact_number');
            $table->longText('description');
            $table->longText('feedback_comment');
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
        Schema::dropIfExists('valid_cases');
    }
};
