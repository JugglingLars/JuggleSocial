<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Like::truncate();

        // run seeder in loop to prevent duplicates from bulk create
        for ($i = 0; $i < 12; $i++) {
            Like::factory()->create();
        }
    }
}
