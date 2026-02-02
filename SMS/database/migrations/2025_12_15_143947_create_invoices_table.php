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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
             $table->foreignId('student_profile_id')->constrained();
    $table->foreignId('term_id')->constrained();
    $table->decimal('total_amount', 10, 2)->default(0);
    $table->string('status')->default('UNPAID');
    $table->unsignedBigInteger('school_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
