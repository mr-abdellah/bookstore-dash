<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $nameEn = $this->faker->unique()->words(2, true);

        return [
            'id' => Str::uuid()->toString(),
            'name_en' => $nameEn,
            'name_fr' => $nameEn, // Simplified; use translation service in production
            'name_ar' => $nameEn, // Simplified; use Arabic translation in production
            'slug' => Str::slug($nameEn),
            'created_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-2 years', 'now'),
        ];
    }
}
