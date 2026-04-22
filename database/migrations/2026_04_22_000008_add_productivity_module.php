<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Module;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Module::updateOrCreate(
            ['name' => 'productivity'],
            [
                'label'         => 'Productivity',
                'description'   => 'Sistem Catatan, Quest Harian, dan Notebook Organisasi',
                'icon_class'    => 'bx bx-rocket',
                'color_from'    => 'from-blue-500',
                'color_to'      => 'to-indigo-600',
                'entry_route'   => 'notes.myday',
                'required_role' => null, // Biarkan null agar bisa diakses user biasa atau atur sesuai kebutuhan
                'order_no'      => 4,
                'is_active'     => true,
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Module::where('name', 'productivity')->delete();
    }
};
