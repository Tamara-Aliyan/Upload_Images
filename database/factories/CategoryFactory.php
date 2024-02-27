<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        // $parentCategory = Category::factory()->create();
        return [
            'name' => $this->faker->name(),
            // 'parent_id' => $parentCategory->id,
        ];
    }
}
