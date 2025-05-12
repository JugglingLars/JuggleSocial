<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);
        $this->call(ImageSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(LikeSeeder::class);
        $this->call(TagSeeder::class);
    }
}
