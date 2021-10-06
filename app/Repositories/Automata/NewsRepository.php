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

    public function getTopFakeNewsSharingUsers(int $userCount = 10): string
    {
        $query = 'select * from detectenv.get_top_users_which_shared_news_ics() order by rate_fake_news desc limit ?;';
        $userDataResult = DB::select($query, [$userCount]);

        return $this->groupResultByKey($userDataResult)->toJson();
    }

    public function getTopNotFakeNewsSharingUsers(int $userCount = 10): string
    {
        $query = 'select * from detectenv.get_top_users_which_shared_news_ics() order by rate_not_fake_news desc limit ?;';
        $userDataResult = DB::select($query, [$userCount]);

        return $this->groupResultByKey($userDataResult)->toJson();
    }

    private function groupResultByKey(array $result): Collection
    {
        $resultCollection = collect($result);
        $keys = array_keys((array) $resultCollection->first());

        $initialValue = collect(array_reduce(
            $keys,
            function ($acc, $key) {
                $acc[$key] = [];
                return $acc;
            },
            []
        ));

        $reducer = fn($accumulator, \stdClass $item) => $accumulator
            ->map(function ($value, string $key) use ($item) {
                $itemArray = (array) $item;
                array_push($value, $itemArray[$key]);
                return $value;
            });

        return $resultCollection->reduce($reducer, $initialValue);
    }
}
