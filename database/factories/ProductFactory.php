<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Brand;
use App\Models\Category;
use Carbon\Carbon;
class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $photos = [
            '/storage/photos/52/img-pro-01.jpg',
            '/storage/photos/52/img-pro-02.jpg',
            '/storage/photos/52/img-pro-03.jpg',
            '/storage/photos/52/img-pro-04.jpg',
        ];
    
        $countdown_date = $this->faker->date('Y-m-d', 'now');
        $countdown_time = $this->faker->time('H:i:s');
        $countdown_duration = rand(3600, 86400);
        $countdown_datetime = Carbon::parse($countdown_date.' '.$countdown_time);
        $now = Carbon::now();
        $countdown = $countdown_datetime->diff($now);
    
        return [
            'title' => $this->faker->sentence(1),
            'slug' => $this->faker->slug(),
            'summary' => $this->faker->paragraph(),
            'description' => $this->faker->text(),
            'cat_id' => function () {
                return Category::factory()->create()->id;
            },
            'child_cat_id' => function () {
                return Category::factory()->create()->id;
            },
            'price' => rand(10000, 100000),
            'brand_id' => function () {
                return Brand::factory()->create()->id;
            },
            'discount' => rand(0, 50),
            'currency' => 'Rp.',
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'photo' => $this->faker->randomElement($photos),
            'stock' => rand(0, 100),
            'is_featured' => rand(0, 1),
            'condition' => $this->faker->randomElement(['new', 'hot']),
            'countdown_date' => $countdown_date,
            'countdown_time' => $countdown_time,
            'countdown_duration' => $countdown_duration,
        ];
    }
    
}
