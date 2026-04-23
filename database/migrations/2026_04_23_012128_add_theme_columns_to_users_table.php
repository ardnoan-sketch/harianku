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
        Schema::table('ar_users', function (Blueprint $table) {
            $table->string('theme')->default('light')->after('theme_mode_id');
            $table->string('accent_color')->nullable()->after('theme');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ar_users', function (Blueprint $table) {
            $table->dropColumn(['theme', 'accent_color']);
        });
    }
};
