<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id'=>User::where('email','test@test.test')->first()->id,
            'description'=> 'NOT REAL FIREARMS!!! This is a image of me playing airsoft, displayed are airsoft replica\'s. ' . $this->faker->sentence(45),
            'image_full_name'=>'CQBWatermerk-49.png'
        ];
    }
}
