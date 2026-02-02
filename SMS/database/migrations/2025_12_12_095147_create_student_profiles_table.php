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
        Schema::create('student_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('admission_no')->nullable()->unique();
        $table->date('date_of_birth')->nullable();
        $table->string('gender')->nullable();
        $table->foreignId('class_level_id')->nullable()->constrained('class_levels')->nullOnDelete();
        $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();
        $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_profiles');
    }
};
