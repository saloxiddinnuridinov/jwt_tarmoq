<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_uz' => $this->faker->word,
            'name_ru' => $this->faker->word,
            'name_en' => $this->faker->word,
            'image' => 'https://static7.tgstat.ru/channels/_0/52/52ac61549c1ad24dab99e4fa1a129bc4.jpg',
            'parent_id' => $this->faker->numberBetween(0, 9)
        ];
    }
}
