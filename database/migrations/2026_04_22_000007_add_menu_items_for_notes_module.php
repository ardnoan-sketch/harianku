<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $menus = [
            [
                'name' => 'My Day',
                'url_or_route' => 'productivity.myday',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-calendar-check',
                'module' => 'productivity',
                'order_no' => 1,
            ],
            [
                'name' => 'Calendar',
                'url_or_route' => 'productivity.calendar',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-calendar',
                'module' => 'productivity',
                'order_no' => 2,
            ],
            [
                'name' => 'Notes',
                'url_or_route' => 'notes.index',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-note',
                'module' => 'productivity',
                'order_no' => 3,
            ],
            [
                'name' => 'Notebook',
                'url_or_route' => 'notebooks.index',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-book-content',
                'module' => 'productivity',
                'order_no' => 4,
            ],
            [
                'name' => 'Quests',
                'url_or_route' => 'productivity.quests.index',
                'icon_type' => 'class',
                'icon_value' => 'bx bx-target-lock',
                'module' => 'productivity',
                'order_no' => 5,
            ],
        ];

        foreach ($menus as $menu) {
            Menu::updateOrCreate(
                ['module' => $menu['module'], 'url_or_route' => $menu['url_or_route']],
                $menu
            );
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Menu::where('module', 'productivity')->delete();
    }
};
