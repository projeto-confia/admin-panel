<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;


class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $userCount = $request->get('user-count', 10);

        return view(
            'welcome',
            [
                'topFakeUsersJson' => $this->getTopFakeNewsSharingUsers($userCount),
                'topNotFakeUsersJson' => $this->getTopNotFakeNewsSharingUsers($userCount),
                'totalNews' => News::count(),
                'totalNewsPredicted' => News::whereNotNull('classification_outcome')->count(),
                'totalNewsChecked' => News::whereNotNull('ground_truth_label')->count(),
                'totalNewsToBeChecked' => News::whereNull('ground_truth_label')->count(),
                'newsCorrectlyPredictedCount' => News::whereNotNull('ground_truth_label')
                    ->whereNotNull('classification_outcome')
                    ->whereColumn('ground_truth_label', 'classification_outcome')
                    ->count(),
            ]
        );
    }

    /**
     * Returns encoded json from top fake news sharing users
     * @param int $userCount
     * @return string
     */
    private function getTopFakeNewsSharingUsers(int $userCount = 10): string
    {
        $query = 'select * from detectenv.get_top_users_which_shared_news_ics() order by rate_fake_news desc limit ?;';
        $userDataResult = DB::select($query, [$userCount]);

        return $this->groupResultByKey($userDataResult)->toJson();
    }

    /**
     * Returns encoded json from top NOT fake news sharing users
     * @param int $userCount
     * @return string
     */
    private function getTopNotFakeNewsSharingUsers(int $userCount = 10): string
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
