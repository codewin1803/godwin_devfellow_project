<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('announcements', function (Blueprint $table) {
        $table->id();
       $table->foreignId('school_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->string('title');
            $table->text('body');

            $table->json('target_roles');

            $table->timestamp('publish_at');
            $table->timestamp('expires_at')->nullable();

            $table->foreignId('created_by')
                ->constrained('users')
                ->cascadeOnDelete();

        $table->timestamps();
    });
}








    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('announcements');
    }
};
