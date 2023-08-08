<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Category;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */

class CategoryFactory extends Factory
{
    protected $model = Category::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $photos = [
            'images/categories_img_01.jpg',
            'images/categories_img_02.jpg',
            'images/categories_img_03.jpg',
        ];
        return [
            'title' => $this->faker->text(5),
            'slug' =>$this->faker->slug,
            'summary' =>$this-> faker->sentence(10),
            'photo' => $this->faker->randomElement($photos),
            'status' => 'active',
            'is_parent' =>'1',
            'parent_id' => $this->faker->randomElement([null, Category::count() ? Category::inRandomOrder()->first()->id : null]),
        ];
    }
}
