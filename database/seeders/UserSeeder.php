<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::truncate();
        User::factory(3)->create();
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@test.test',
            'password' => Hash::make('testtest1'),
        ]);
    }
}
