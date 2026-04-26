<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('project_stages', function (Blueprint $table) {
            $table->id();

            // RELATIONSHIPS
            $table->foreignId('project_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->foreignId('stage_id')
                  ->constrained()
                  ->onDelete('cascade');

            // SUPERVISOR CONTROL
            $table->string('deliverable')->nullable();
            $table->date('deadline')->nullable();
            $table->boolean('is_open')->default(false);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('project_stages');
    }
};