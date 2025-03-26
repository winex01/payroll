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
        Schema::create('relations', function (Blueprint $table) {
            $table->id();

            // Polymorphic relation
            $table->morphs('relationable'); // Creates `relationable_id` and `relationable_type`

            // Employee association
            $table->foreignId('employee_id')
                ->constrained()
                ->cascadeOnDelete()
                ->cascadeOnUpdate();

            $table->foreignId('relationship_id')
                ->nullable()
                ->constrained('relationships')
                ->onDelete('set null');

            // Shared fields
            $table->string('last_name');
            $table->string('first_name');
            $table->string('middle_name');
            $table->date('birth_date')->nullable();
            $table->string('occupation')->nullable();
            $table->string('contact_no')->nullable();
            $table->string('address')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('relations');
    }
};
