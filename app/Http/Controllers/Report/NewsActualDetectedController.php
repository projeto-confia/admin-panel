<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\News;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsActualDetectedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $this->handleIntervalNavigation($request);

        $reportData = News::query()
            ->select(
                News::raw('datetime_publication::DATE'),
                News::raw('count(classification_outcome) as num_detected'),
                News::raw('count(case when ground_truth_label then 1 end) as num_actual')
            )
            ->where('classification_outcome', '=', true)
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
            ->groupBy(News::raw('datetime_publication::DATE'))
            ->orderby('datetime_publication')
            ->get()
            ->reduce(function ($acc, $item) {
                array_push($acc['labels'], $item->datetime_publication->format('d/m/Y'));
                array_push($acc['detected_fake'], $item->num_detected);
                array_push($acc['actual_fake'], $item->num_actual);
                return $acc;
            }, [
                'labels' => [],
                'detected_fake' => [],
                'actual_fake' => []
            ]);

        $reportJson = json_encode($reportData);
        return view('pages.report.news_actual_detected', compact('reportJson', 'request'));
    }

    private function handleIntervalNavigation(Request $request)
    {
        if (!$request->next_interval && !$request->previous_interval) {
            return;
        }

        $request->validate(
            [
                'start_date' => 'required|date',
                'end_date' => 'required|date',
            ],
            [
                'start_date.required' => 'As datas são requeridas para navegar por intervalos',
            ]
        );

        /** @var Carbon */
        $startDate = Carbon::parse($request->start_date);
        /** @var Carbon */
        $endDate = Carbon::parse($request->end_date);

        $differenceInDays = $startDate->diffInDays($endDate) + 1;

        if ($request->next_interval) {
            $startDate->addDays($differenceInDays);
            $endDate->addDays($differenceInDays);
        }

        if ($request->previous_interval) {
            $startDate->subDays($differenceInDays);
            $endDate->subDays($differenceInDays);
        }

        $request->merge([
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
        ]);
    }

}
