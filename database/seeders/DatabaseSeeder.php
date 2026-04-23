<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Core Data
        $this->call([
            ThemeModeSeeder::class,
            ModuleSeeder::class,
            MenuSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
        ]);

        // 2. Dummy Data for Development
        $user = User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => \Illuminate\Support\Facades\Hash::make('password'),
        ]);

        $categories = \App\Models\Category::factory(5)->create([
            'user_id' => $user->id,
        ]);

        foreach ($categories as $category) {
            \App\Models\Transaction::factory(10)->create([
                'user_id' => $user->id,
                'category_id' => $category->id,
            ]);
        }
    }

}
