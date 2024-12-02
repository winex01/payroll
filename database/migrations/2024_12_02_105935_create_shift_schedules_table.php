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
        Schema::create('shift_schedules', function (Blueprint $table) {
            $table->id();

            $table->string('name')->unique();
            $table->boolean('open_time')->default(0);
            $table->boolean('early_login_overtime')->default(0);
            $table->boolean('after_shift_overtime')->default(1);
            $table->boolean('night_differential')->default(1);
            $table->json('working_hours')->nullable();
            $table->string('day_start')->nullable();
            $table->text('description')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shift_schedules');
    }
};
