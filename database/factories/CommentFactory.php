<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item=null;

        if(rand(0,1)==0||Comment::all()->count()==0)
            $item = Image::inRandomOrder()->first();
        else
            $item = Comment::inRandomOrder()->first();
        
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'comment_text' => $this->faker->paragraph(),
            'comment_on_id' => $item->id,
            'comment_on_type' => get_class($item),
        ];
    }
}
