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
        Schema::create('ar_modules', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();         // key unik, contoh: 'hrd', 'finance'
            $table->string('label');                   // Tampil di portal: 'Human Resource'
            $table->string('description')->nullable(); // Deskripsi singkat di kartu portal
            $table->string('icon_class')->default('bx bx-cube'); // Boxicon class
            $table->string('color_from')->default('from-blue-500');  // Tailwind gradient start
            $table->string('color_to')->default('to-blue-700');      // Tailwind gradient end
            $table->string('entry_route');             // Route name untuk masuk ke modul
            $table->string('required_role')->nullable(); // Role Spatie yang dibutuhkan
            $table->integer('order_no')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ar_modules');
    }
};
