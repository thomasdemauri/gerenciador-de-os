<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\CustomerSeeder;
use Database\Seeders\HandymanServiceSeeder;
use Database\Seeders\ProductServiceSeeder;
use Database\Seeders\ServiceOrderSeeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CustomerSeeder::class,
            HandymanServiceSeeder::class,
            ProductServiceSeeder::class,
            ServiceOrderSeeder::class
        ]);
    }
}
