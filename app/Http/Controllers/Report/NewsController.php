<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Automata\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
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
        $news = News::query()
            ->whereNotNull('prob_classification')
            ->when(
                $request->text_news,
                fn($query) => $query->where('text_news', 'ilike', "%{$request->text_news}%")
            )
            ->when(
                in_array($request->ground_truth_label, ['0', '1'], true) && $request->ground_truth_label !== '*',
                fn($query) => $query->where('ground_truth_label', $request->ground_truth_label),
                fn($query) => $query->whereNotNull('ground_truth_label'),
            )
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
            ->orderBy('datetime_publication')
            ->paginate()
            ->withQueryString();


        return view('pages.report.news', compact('news', 'request'));
    }
}
