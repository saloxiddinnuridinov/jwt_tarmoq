<?php

namespace Database\Factories;

use App\Models\Term;
use Illuminate\Database\Eloquent\Factories\Factory;

class TermFactory extends Factory
{
    protected $model = Term::class;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'keyword_latin' => $this->faker->word,
            'keyword_ru' => $this->faker->word,
            'keyword_uz' => $this->faker->word,
            'keyword_en' => $this->faker->word,
            'description_uz' => $this->faker->text($maxNbChars = 200),
            'description_ru' => $this->faker->text($maxNbChars = 200),
            'description_en' => $this->faker->text($maxNbChars = 200),
        ];
    }
}
