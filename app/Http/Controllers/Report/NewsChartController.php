<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Automata\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

// Quantitativo
class NewsChartController extends Controller
{
    use IntervalNavigable;
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $this->handleIntervalNavigation($request);

        $result = News::query()
            ->whereNotNull('prob_classification')
            ->select(News::raw('datetime_publication::DATE'), 'ground_truth_label', News::raw('count(*) as total'))
            ->whereNotNull('ground_truth_label')
            ->whereNotNull('prob_classification')
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
                function ($query) use ($request) {
                    $sixDaysAgo = Carbon::now()->subDays(6);
                    $request->merge(['start_date' =>  $sixDaysAgo->toDateString()]);
                    $query->whereDate('datetime_publication', '>=', $sixDaysAgo);
                }
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
                function ($query) use ($request) {
                    $today = Carbon::now();
                    $request->merge(['end_date' =>  $today->toDateString()]);
                    $query->whereDate('datetime_publication', '<=', $today);
                }
            )
            ->groupBy(News::raw('datetime_publication::DATE'), 'ground_truth_label')
            ->orderby('datetime_publication')
            ->orderby('ground_truth_label')
            ->get();

        $reportData = collect($result->toArray())
            ->groupBy('datetime_publication')
            ->reduce(
                /**
                 * @param array{labels: array, data_true: array, data_false: array} $acc
                 * @param Collection<array{datetime_publication: string, ground_truth_label: bool, total: int}> $item
                 * @return array
                 */
                function (array $acc, Collection $item, $key): array {

                    $date = Carbon::createFromDate($key);
                    $label = $date->format('d/m/Y');
                    $hasLabel = (bool) Arr::first($acc['labels'], fn($it) => $it == $label);

                    if (! $hasLabel) {
                        $acc['labels'][] = $label;
                    }

                    $whereGroundTruthLabelIs = fn($value) => fn($data) => $data['ground_truth_label'] == $value;
                    $dataFalse = $item->first($whereGroundTruthLabelIs(true), []);
                    $dataTrue = $item->first($whereGroundTruthLabelIs(false), []);

                    $acc['data_false'][] = data_get($dataFalse, 'total', 0);
                    $acc['data_true'][] = data_get($dataTrue, 'total', 0);

                    return $acc;
                }, [
                    'labels' => [],
                    'data_true' => [],
                    'data_false' => []
                ]
            );

        $reportJson = json_encode($reportData);
        return view('pages.report.news_chart', compact('reportJson', 'request'));
    }
}
