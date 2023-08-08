<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductReview>
 */
class ProductReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => function () {
                return User::factory()->create()->id;
            },// set user_id dengan nilai acak antara 1 sampai 10
            'product_id' =>function () {
                return Product::factory()->create()->id;
            },// set product_id dengan nilai acak antara 1 sampai 20
            'rate' => rand(1, 5), // set rate dengan nilai acak antara 1 sampai 5
            'review' => $this->faker->paragraph, // set review dengan kalimat acak yang dibuat oleh faker
            'status' => 'active', // set status menjadi active
        ];
    }
}
