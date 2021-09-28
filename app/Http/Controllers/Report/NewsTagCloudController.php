<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\Automata\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class NewsTagCloudController extends Controller
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

        $stopWords = file(storage_path('files/stopwords.txt'), FILE_IGNORE_NEW_LINES);

        $reportJson = News::query()
            ->select('text_news_cleaned')
            ->whereHas('curatorship', function (Builder $curatorshipQuery) use ($request) {
                $curatorshipQuery
                    ->where('is_news', true)
                    ->where('is_curated', true)
                    ->when(
                        in_array($request->ground_truth_label, ['0', '1'], true)
                        && $request->ground_truth_label !== '*',
                        fn($query) => $query->where('is_fake_news', $request->ground_truth_label),
                        fn($query) => $query->whereNotNull('is_fake_news'),
                    );
            })
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
            ->limit(100)
            ->get()
            ->flatMap(function (News $news) use($stopWords) {
                $words = preg_split('/[^-\w\']+/', $news->text_news_cleaned, -1, PREG_SPLIT_NO_EMPTY);
                $words = array_map('strtolower', $words);
                return array_diff($words, $stopWords);
            })
            ->countBy()
            ->sort()
            ->reverse()
            ->map(fn (int $wordCount, string $key) => ['x' => $key, 'value' => $wordCount])
            ->values()
            ->toJson();

        return view('pages.report.news_tagcloud', compact('reportJson', 'request'));
    }
}
