<?php

namespace Database\Seeders;

use App\Models\Customer;
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
//        $this->call([
//            CustomerSeeder::class,
//            HandymanServiceSeeder::class,
//            ProductServiceSeeder::class,
//            ServiceOrderSeeder::class
//        ]);

        $user = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com'
        ]);

        $customers = Customer::factory()->count(3)->create([
            'user_id' => $user->id,
        ]);

    }
}
