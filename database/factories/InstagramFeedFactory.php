<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\InstagramFeed;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InstagramFeed>
 */
class InstagramFeedFactory extends Factory
{
    protected $model = InstagramFeed::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $photos = [
            '/storage/photos/52/instagram-img-01.jpg',
            '/storage/photos/52/instagram-img-02.jpg',
            '/storage/photos/52/instagram-img-03.jpg',
            '/storage/photos/52/instagram-img-04.jpg',
            '/storage/photos/52/instagram-img-05.jpg',
            '/storage/photos/52/instagram-img-06.jpg',
            '/storage/photos/52/instagram-img-07.jpg',
            '/storage/photos/52/instagram-img-08.jpg',
            '/storage/photos/52/instagram-img-09.jpg',
        ];
        return [
            'name' => $this->faker->name,
            'photo' => $this->faker->randomElement($photos),
            'instagram' => $this->faker->name,
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
