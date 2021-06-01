<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $reportData = News::query()
            ->select(News::raw('datetime_publication::DATE'), 'ground_truth_label', News::raw('count(*) as total'))
            ->whereNotNull('ground_truth_label')
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
                function ($query) {
                    $sevenDaysAgo = Carbon::now()->subDays(7);
                    $query->whereDate('datetime_publication', '>=', $sevenDaysAgo);
                }
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
                fn($query) => $query->whereDate('datetime_publication', '<=', Carbon::now()),
            )
            ->groupBy(News::raw('datetime_publication::DATE'), 'ground_truth_label')
            ->orderby('datetime_publication')
            ->orderby('ground_truth_label')
            ->get()
            ->reduce(function ($acc, $item) {
                $label = $item->datetime_publication->format('d/m/Y');
                $hasLabel = (bool) Arr::first($acc['labels'], fn($it) => $it == $label);

                if (!$hasLabel) {
                    array_push($acc['labels'], $label);
                }

                $key = $item->ground_truth_label ? 'data_true' : 'data_false';
                array_push($acc[$key], $item->total);

                return $acc;
            }, [
                'labels' => [],
                'data_true' => [],
                'data_false' => []
            ]);

        // $data = [
        //     "labels" => ['12/02/2021', '14/02/2021', '20/02/2021', '21/02/2021', '22/02/2021', '23/02/2021'],
        //     "data_true" => [12, 19, 3, 12, 19, 3],
        //     "data_false" => [20, 15, 8, 12, 19, 3]
        // ];

        $reportJson = json_encode($reportData);
        return view('pages.report.news_chart', compact('reportJson', 'request'));
    }
}
