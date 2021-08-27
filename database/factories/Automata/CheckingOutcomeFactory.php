<?php

namespace Database\Factories\Automata;

use App\Models\Automata\CheckingOutcome;
use Illuminate\Database\Eloquent\Factories\Factory;

class CheckingOutcomeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CheckingOutcome::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $datetimeOutcome = $this->faker->dateTimeBetween('-3 months');
        return [
            'datetime_outcome' => $datetimeOutcome,
            'datetime_sent_for_checking' => $this->faker->dateTimeBetween($datetimeOutcome),
            'is_fake' => $this->faker->boolean(),
            'trusted_agency_link' => $this->faker->url,
        ];
    }
}
