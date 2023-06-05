<?php

namespace Database\Factories;

use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

class StudentFactory extends Factory
{
    protected $model = Student::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'surname' => $this->faker->lastname(),
            'email' => $this->faker->unique()->safeEmail(),
            // 'email_verified_at' => now(),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'block_reason' => $this->faker->text($maxNbChars = 200),
            'is_blocked' => $this->faker->boolean(),
            'password' => Hash::make("user"),
            'balance' => $this->faker->numberBetween(1, 9999),
            'birthday' => $this->faker->dateTime(),
        ];
    }
}
