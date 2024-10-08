<?php

use App\Enums\AcademicPeriod;
use App\Enums\ScheduleDay;
use App\Enums\ScheduleLocation;
use App\Enums\ScheduleShift;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up() : void
    {
        Schema::create('schedules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('class_subject_id')->constrained('class_subject')->cascadeOnDelete();
            $table->foreignId('pj_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('class_subject_name');
            $table->string('pj_name');
            $table->string('academic_year');
            $table->enum('academic_period', AcademicPeriod::getValues());
            $table->enum('location', ScheduleLocation::getValues());
            $table->enum('day', ScheduleDay::getValues());
            $table->enum('shift', ScheduleShift::getValues());
            $table->smallInteger('total_session')->default(8);
            $table->smallInteger('session')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down() : void
    {
        Schema::dropIfExists('schedules');
    }
};
