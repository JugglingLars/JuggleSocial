<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Image;
use App\Models\Like;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Like>
 */
class LikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $item = $this->get_new_parent();
        
        return [
            'user_id'       => $item['user_id'],
            'likeable_id'   => $item['likeable_id'],
            'likeable_type' => $item['likeable_type'],
        ];
    }

    private function get_new_parent(): array
    {
        $attempts = 0;
        $maxAttempts = 10;

        do {
            $user = User::inRandomOrder()->first();
            $item = rand(0, 1) === 0
                ? Image::inRandomOrder()->first()
                : Comment::inRandomOrder()->first();

            $exists = Like::where('user_id', $user->id)
                ->where('likeable_id', $item->id)
                ->where('likeable_type', get_class($item))
                ->exists();

            $attempts++;
        } while ($exists && $attempts < $maxAttempts);

        if ($exists) {
            throw new \Exception('Unable to generate a unique like after several attempts.');
        }
    
        return [
            'user_id'       => $user->id,
            'likeable_id'   => $item->id,
            'likeable_type' => get_class($item),
        ];
    }
}
