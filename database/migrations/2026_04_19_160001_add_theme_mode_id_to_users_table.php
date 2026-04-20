<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ar_users', function (Blueprint $table) {
            $table->foreignId('theme_mode_id')
                ->nullable()
                ->after('remember_token')
                ->constrained('ar_theme_modes')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('ar_users', function (Blueprint $table) {
            $table->dropConstrainedForeignId('theme_mode_id');
        });
    }

};
