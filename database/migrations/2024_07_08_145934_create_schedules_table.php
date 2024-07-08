<?php

use App\Enums\ScheduleDay;
use App\Enums\ScheduleShift;
use App\Models\ClassSubject;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(ClassSubject::class)->constrained()->cascadeOnDelete();
            $table->foreignId('pj_id')->constrained('users')->cascadeOnDelete();
            $table->string('class_subject_name');
            $table->string('pj_name');
            $table->smallInteger('academic_year');
            $table->enum('day', ScheduleDay::getValues());
            $table->enum('shift', ScheduleShift::getValues());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedules');
    }
};
