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
        Schema::create('ar_menus', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('url_or_route')->nullable();
            $table->enum('icon_type', ['class', 'image'])->default('class');
            $table->string('icon_value')->nullable(); // e.g., 'bx bx-home' or 'menu_icons/home.png'
            $table->foreignId('parent_id')->nullable()->constrained('ar_menus')->nullOnDelete();
            $table->string('module')->default('admin'); // 'admin', 'finance', 'portal'
            $table->string('permission_name')->nullable(); // To link with Spatie
            $table->integer('order_no')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ar_menus');
    }
};
