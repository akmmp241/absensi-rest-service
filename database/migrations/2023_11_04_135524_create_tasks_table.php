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
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->nullable(false);
            $table->string('image')->nullable(false);
            $table->text('detail')->nullable(false);
            $table->string('status', ['not confirmed', 'confirm'])->nullable(false)->default('not confirmed');
            $table->foreignId('confirmed_by')->constrained('supervisors')->nullable(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
