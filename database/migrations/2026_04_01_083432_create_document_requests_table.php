<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_requests', function (Blueprint $table) {
            $table->id();
            $table->string('request_code', 30)->unique();
            $table->foreignId('resident_id')
                  ->constrained('residents')
                  ->cascadeOnDelete();
            $table->foreignId('document_type_id')
                  ->constrained('document_types')
                  ->cascadeOnDelete();
            $table->string('purpose', 255);
            $table->enum('status', ['pending', 'approved', 'released', 'rejected'])
                  ->default('pending');
            $table->foreignId('approved_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->foreignId('released_by')
                  ->nullable()
                  ->constrained('users')
                  ->nullOnDelete();
            $table->timestamp('approved_at')->nullable();
            $table->timestamp('released_at')->nullable();
            $table->text('admin_notes')->nullable();
            $table->string('generated_file')->nullable();
            $table->timestamp('requested_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_requests');
    }
};