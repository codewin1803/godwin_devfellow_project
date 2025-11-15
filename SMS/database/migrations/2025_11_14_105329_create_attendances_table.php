<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->enum('status', ['PRESENT', 'ABSENT', 'LATE']);
            $table->timestamps();

            $table->unique(['student_id', 'date']); // Prevent duplicate entries
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
