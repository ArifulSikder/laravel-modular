<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\AdminSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    // public function run(): void
    // {
    //     // User::factory(10)->create();
    // }

    public function run()
    {
        $this->call([
            \Database\Seeders\PermissionsSeeder::class,
            AdminSeeder::class,
        ]);
    }

}
