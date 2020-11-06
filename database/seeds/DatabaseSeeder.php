<?php

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
        // DatabaseSeeder called TagSeeder
        // Alles gaat altijd via DatabaseSeeder naar andere Seeders
        $this->call(TagSeeder::class);
        $this->caLL(UserSeeder::class);
    }
}
