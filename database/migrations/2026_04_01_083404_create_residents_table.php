<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('residents', function (Blueprint $table) {
            $table->id();
            $table->string('resident_code', 20)->unique();
            $table->string('first_name', 80);
            $table->string('middle_name', 80)->nullable();
            $table->string('last_name', 80);
            $table->string('suffix', 10)->nullable();
            $table->date('birthdate');
            $table->enum('gender', ['male', 'female', 'other']);
            $table->enum('civil_status', ['single', 'married', 'widowed', 'separated']);
            $table->string('purok_zone', 100);
            $table->text('address');
            $table->string('contact_number', 20)->nullable();
            $table->string('email', 150)->nullable();
            $table->string('profile_picture')->nullable();
            $table->tinyInteger('is_voter')->default(0);
            $table->tinyInteger('is_senior_citizen')->default(0);
            $table->tinyInteger('is_pwd')->default(0);
            $table->tinyInteger('is_solo_parent')->default(0);
            $table->tinyInteger('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('residents');
    }
};