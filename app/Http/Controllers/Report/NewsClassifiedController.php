<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Automata\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class NewsClassifiedController extends Controller
{
    use IntervalNavigable;

    public function __invoke(Request $request): View
    {
        $this->handleIntervalNavigation($request);
        $query = News::query()
            ->whereNotNull('prob_classification')
            ->when(
                $request->text_news,
                fn($query) => $query->where('text_news', 'ilike', "%{$request->text_news}%")
            );

        $this->classificationFilters($query, $request);
        $this->labelFilters($query, $request);
        $this->dateIntervalFilters($query, $request);

        /** @var LengthAwarePaginator $news */
        $news = $query->orderBy('datetime_publication')
            ->paginate()
            ->withQueryString();

        return view('pages.report.news-classified', compact('news', 'request'));
    }


    private function classificationFilters(Builder $query, Request $request)
    {
        $query->when(
            in_array($request->classification_outcome, ['0', '1'], true),
            fn($query) => $query->where('classification_outcome', $request->classification_outcome),
            fn($query) => $query->whereNotNull('classification_outcome'),
        );
    }

    private function labelFilters(Builder $query, Request $request)
    {
        $query->when(
            in_array($request->ground_truth_label, ['0', '1'], true),
            fn($query) => $query->where('ground_truth_label', $request->ground_truth_label),
        )
        ->when(
            $request->ground_truth_label == 'unlabelled',
            fn($query) => $query->whereNull('ground_truth_label'),
        )
        ->when(
            $request->ground_truth_label == 'labelled',
            fn($query) => $query->whereNotNull('ground_truth_label'),
        );
    }

    private function dateIntervalFilters(Builder $query, Request $request)
    {
        $query->when(
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
        );
    }
}
