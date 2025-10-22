<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Modules\V1\Player\Models\Player;

/**
 * @extends Factory<Player>
 */
class PlayerFactory extends Factory
{
    protected $model = Player::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => Str::uuid()->toString(),
            'username' => fake()->userName(),
            'score' => fake()->numberBetween(1, 5000),
        ];
    }
}
