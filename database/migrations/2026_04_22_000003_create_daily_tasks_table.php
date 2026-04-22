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
        Schema::create('ar_daily_tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('daily_log_id')->constrained('ar_daily_logs')->onDelete('cascade');
            $table->enum('type', ['morning', 'afternoon', 'evening']);
            $table->string('title');
            $table->boolean('is_completed')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_daily_tasks');
    }
};
