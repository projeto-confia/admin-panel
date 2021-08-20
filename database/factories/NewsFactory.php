<?php

namespace Database\Factories;

use App\Models\Automata\News;
use Illuminate\Database\Eloquent\Factories\Factory;

class NewsFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = News::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'text_news' => $this->faker->text,
            'datetime_publication' => $this->faker->dateTime(),
            'classification_outcome' => $this->faker->boolean(),
            'ground_truth_label' => $this->faker->boolean(),
            'prob_classification' => $this->faker->randomFloat(2, 0, 1),
            'text_news_cleaned' => $this->faker->text
        ];
    }
}
