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
        Schema::create('ar_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('ar_users')->onDelete('cascade');
            $table->string('title');
            $table->text('content')->nullable();
            $table->enum('type', ['daily_note', 'general_note'])->default('general_note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_notes');
    }
};
