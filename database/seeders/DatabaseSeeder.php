<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call(SettingDatabaseSeeder::class);
        $this->call(AdminDatabaseSeeder::class);
        $this->call(CategoryDatabaseSeeder::class);
        $this->call(ProductDatabaseSeeder::class);
        $this->call(BrandDatabaseSeeder::class);
        $this->call(TagDatabaseSeeder::class);

    }
}
