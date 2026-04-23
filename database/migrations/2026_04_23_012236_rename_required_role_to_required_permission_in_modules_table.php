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
        Schema::table('ar_modules', function (Blueprint $table) {
            $table->renameColumn('required_role', 'required_permission');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ar_modules', function (Blueprint $table) {
            $table->renameColumn('required_permission', 'required_role');
        });
    }
};
