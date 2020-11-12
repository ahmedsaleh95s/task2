<?php

namespace Database\Factories;

use App\Models\ServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServiceProviderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ServiceProvider::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $lat = $this->faker->latitude;
        $long = $this->faker->longitude;
        return [
            //
            'name_ar' => $this->faker->name,
            'name_en' => $this->faker->name,
            'phone' => '9665' . $this->faker->randomNumber(5),
            'email' => $this->faker->unique()->freeEmail,
            'lat' => $this->faker->latitude,
            'long' => $this->faker->longitude,
            'Categories' => [1, 2, 3],
            'Area_polygon' => [
                [$lat, $long],
                [$this->faker->latitude, $this->faker->longitude],
                [$this->faker->latitude, $this->faker->longitude],
                [$this->faker->latitude, $this->faker->longitude],
                [$lat, $long],
            ],
            'working_hours' => [
                [
                    "from" => '03:00 pm',
                    'to' => '04:00 pm',
                    "day" => 1
                ]
            ],
            'password' => '12345678'
        ];
    }
}
