<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title_uz' => $this->faker->word,
            'title_ru' => $this->faker->word,
            'title_en' => $this->faker->word,
            'category_id' => Category::all()->random()->id,
        ];
    }
}
