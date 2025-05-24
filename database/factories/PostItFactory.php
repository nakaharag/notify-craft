<?php

namespace Database\Factories;

use App\Models\PostIt;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostItFactory extends Factory
{
    protected $model = PostIt::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(),
            'color' => $this->faker->randomElement(['yellow', 'blue', 'green', 'pink', 'white']),
            'font_family' => $this->faker->randomElement(['Arial', 'Helvetica', 'Times New Roman', 'Courier New']),
            'font_size' => $this->faker->randomElement(['small', 'medium', 'large']),
            'size' => $this->faker->randomElement(['S', 'M', 'L']),
        ];
    }
}
