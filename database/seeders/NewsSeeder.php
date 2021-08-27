<?php

namespace Database\Seeders;

use App\Models\Automata\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        News::factory()->count(50)->create();
    }
}
