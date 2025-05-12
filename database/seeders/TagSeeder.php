<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tag::truncate();
        $tags = [Tag::create(['title'=>'Circus'])];
        array_push($tags, Tag::create(['title'=>'Airsoft']));
        array_push($tags, Tag::factory()->count(10)->create());
        

        $images = Image::all();
        foreach ($images as $key => $image) {
            $image->tags()->attach(
                Tag::inRandomOrder()->take(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}
