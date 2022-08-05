<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => password_hash("12345678", PASSWORD_BCRYPT, ['cost' => 12]),
            "contact" => $this->faker->phoneNumber,
            "status_id" => rand(1,3),
            "company_id" => rand(1,20),
            "image" => $this->faker->imageUrl,
            "role_id" => 2
        ];
    }
}
