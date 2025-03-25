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
        Schema::create('families', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('employee_id')
                ->constrained()
                ->onDelete('cascade')
                ->onUpdate('cascade');

            $table->foreignId('relationship_id')
                ->nullable()
                ->constrained('relationships')
                ->onDelete('set null');

            // Family member details
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
        Schema::dropIfExists('families');
    }
};
