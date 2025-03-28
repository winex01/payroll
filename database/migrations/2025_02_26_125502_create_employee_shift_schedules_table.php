<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('employee_shift_schedules', function (Blueprint $table) {
            $table->id();

            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            // monday
            $table->unsignedBigInteger('monday_id')->nullable();
            $table->foreign('monday_id')->references('id')->on('shift_schedules');

            // tuesday
            $table->unsignedBigInteger('tuesday_id')->nullable();
            $table->foreign('tuesday_id')->references('id')->on('shift_schedules');

            // wednesday
            $table->unsignedBigInteger('wednesday_id')->nullable();
            $table->foreign('wednesday_id')->references('id')->on('shift_schedules');

            // thursday
            $table->unsignedBigInteger('thursday_id')->nullable();
            $table->foreign('thursday_id')->references('id')->on('shift_schedules');

            // friday
            $table->unsignedBigInteger('friday_id')->nullable();
            $table->foreign('friday_id')->references('id')->on('shift_schedules');

            // saturday
            $table->unsignedBigInteger('saturday_id')->nullable();
            $table->foreign('saturday_id')->references('id')->on('shift_schedules');

            // sunday
            $table->unsignedBigInteger('sunday_id')->nullable();
            $table->foreign('sunday_id')->references('id')->on('shift_schedules');

            // effectivity date
            $table->date('effectivity_date');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_shift_schedules');
    }
};
