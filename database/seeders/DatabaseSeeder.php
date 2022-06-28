<?php

namespace Database\Seeders;

use App\Models\Report\Violation;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
        ]);

        Violation::create([
            'name' => 'Забыт',
        ]);

        Violation::create([
            'name' => 'Утеря',
        ]);

        Violation::create([
            'name' => 'Сломано',
        ]);
    }
}
