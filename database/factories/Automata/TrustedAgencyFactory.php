<?php

namespace Database\Factories\Automata;

use App\Models\Automata\TrustedAgency;
use Illuminate\Database\Eloquent\Factories\Factory;

class TrustedAgencyFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrustedAgency::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name_agency' => $this->faker->text(20),
            'email_agency' => $this->faker->companyEmail,
            'days_of_week' => 'Monday,Tuesday,Wednesday,Thursday,Friday',
        ];
    }
}
