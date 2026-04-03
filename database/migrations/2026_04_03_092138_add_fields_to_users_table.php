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
        Schema::table('users', function (Blueprint $table) {

            $table->string('role')->default('student'); 
            $table->string('registration_number')->nullable()->unique();
            $table->boolean('must_change_password')->default(true);
            $table->unsignedBigInteger('supervisor_id')->nullable();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'registration_number',
                'must_change_password',
                'supervisor_id'
            ]);
        });
    }
   
};
