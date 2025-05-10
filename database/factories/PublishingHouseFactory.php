<?php

namespace Database\Factories;

use App\Models\PublishingHouse;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PublishingHouseFactory extends Factory
{
    protected $model = PublishingHouse::class;

    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'owner_id' => User::factory()->state(['role' => 'owner']),
            'name' => $this->faker->company(),
            'email' => $this->faker->unique()->companyEmail(),
            'phone' => '0' . $this->faker->numberBetween(5, 7) . $this->faker->numerify('#######'),
            'address' => $this->faker->address(),
            'website' => $this->faker->url(),
            'established_year' => $this->faker->randomFloat(2, 0, 1) < 0.8
                ? $this->faker->dateTimeBetween('-100 years', 'now')->format('Y-m-d')
                : null,
            'logo' => $this->faker->imageUrl(200, 200, 'business'),
            'description' => $this->faker->paragraph(4),
            'social_links' => [
                'facebook' => $this->faker->url(),
                'twitter' => $this->faker->url(),
            ],
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'created_at' => $this->faker->dateTimeBetween('-5 years', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-5 years', 'now'),
        ];
    }
}
