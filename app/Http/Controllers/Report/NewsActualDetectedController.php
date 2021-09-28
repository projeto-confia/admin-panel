<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Automata\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsActualDetectedController extends Controller
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

        $reportData = News::query()
            ->join('curatorship', 'curatorship.id_news', '=', 'news.id_news')
            ->select(
                News::raw('datetime_publication::DATE'),
                News::raw('count(classification_outcome) as num_detected'),
                News::raw('count(case when curatorship.is_fake_news then 1 end) as num_actual')
            )
            ->where('classification_outcome', true)
            ->where('curatorship.is_news', true)
            ->whereNotNull('curatorship.is_fake_news')
            ->where('curatorship.is_curated', true)
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
}
