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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->nullable(false);
            $table->foreignId('supervisor_id')->constrained('supervisors')->nullable(false);
            $table->foreignId('dudi_id')->constrained('dudis')->nullable(false);
            $table->string('nis')->nullable(false)->unique();
            $table->string('name')->nullable(false);
            $table->string('class')->nullable(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
