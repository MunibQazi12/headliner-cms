<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserRoleTableSeeder::class);
        $this->call(UserTableSeeder::class);
        $this->call(CmsSeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(IndustrySeeder::class);
        $this->call(ChooseForSeeder::class);
        
    }
}
