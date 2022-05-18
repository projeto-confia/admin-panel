<?php

namespace App\Http\Controllers;

use App\Models\Automata\Curatorship;
use App\Models\Automata\News;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;


class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        //  Feito consulta baseada em curadoria temporariamente
        $curatorshipCount = Curatorship::count();

        $newsToBeCurated = Curatorship::where('is_curated', false)->count();

        return view(
            'welcome',
            [
                'totalNewsPredicted' => News::whereNotNull('classification_outcome')
                    ->whereNotNull('prob_classification')
                    ->count(),
                'totalNewsChecked' => News::checked()->count(),
                'totalNewsToBeChecked' => $newsToBeCurated,

                'totalNewsCollectedFromSocialNetworks' => News::count() - News::whereNotNull('ground_truth_label')
                    ->whereNull('prob_classification')
                    ->count(),
                'totalNewsFakeByAutomata' => News::checked()->count(),

                'newsCorrectlyPredictedCount' => Curatorship::where('is_curated', true)
                    ->where('is_news', true)
                    ->where('is_fake_news', true)
                    ->count(),
                'curatorshipCount' => $curatorshipCount
            ]
        );
    }
}
