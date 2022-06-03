<?php

namespace App\Repositories\Automata;

use App\Models\Automata\News;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class NewsRepository
{
    public function totalCollected(): int
    {
        return News::count() - News::whereNotNull('ground_truth_label')
                ->whereNull('prob_classification')
                ->count();
    }

    public function totalPredicted(): int
    {
        return News::predicted()->count();
    }

    public function totalChecked(): int
    {
        return News::checked()->count();
    }

    public function totalNotChecked(): int
    {
        return News::notChecked()->count();
    }

    public function totalCorrectlyPredicted(): int
    {
        return News::where('classification_outcome', true)
            ->where('ground_truth_label', true)
            ->whereNotNull('prob_classification')
            ->count();
    }
}
