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
        Schema::create('classroom_assignment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('teacher_profile_id')->constrained()->cascadeOnDelete();
        $table->foreignId('class_level_id')->constrained()->cascadeOnDelete();
        $table->foreignId('section_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
        $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['teacher_profile_id','class_level_id','section_id','subject_id'], 'unique_classroom_assignment');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classroom_assignment');
    }
};
