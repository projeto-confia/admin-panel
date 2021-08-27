<?php

namespace Database\Seeders;

use App\Models\Automata\TrustedAgency;
use Illuminate\Database\Seeder;

class TrustedAgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TrustedAgency::factory()->count(2)->create();
    }
}
