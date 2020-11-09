<?php

namespace Database\Factories;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdminFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'email' => $this->faker->unique()->safeEmail,
            'password' => '$2y$10$ZsDpAaKbe4vxkSENKelmUOIS.lqVniVSsv6LSZq2DWch2mxfr0Xw2', // 12345678
        ];
    }
}
