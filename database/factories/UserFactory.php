<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->freeEmail,
            'password' => '12345678',
            'phone' => '9665'. $this->faker->randomNumber(5),
            'remember_token' => Str::random(60),
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
        ];
    }
}
