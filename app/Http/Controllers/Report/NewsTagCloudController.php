<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Trait\IntervalNavigable;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
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
            ->select('text_news')
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
            ->when(
                in_array($request->ground_truth_label, [0, 1]) && $request->ground_truth_label !== '*',
                fn($query) => $query->where('ground_truth_label', !$request->ground_truth_label),
                fn($query) => $query->whereNotNull('ground_truth_label'),
            )
            ->get()
            ->flatMap(function (News $news) use($stopWords) {
                $words = preg_split('/[^-\w\']+/', $news->text_news, -1, PREG_SPLIT_NO_EMPTY);
                $words = array_map('strtolower', $words);
                return array_diff($words, $stopWords);
            })
            ->countBy()
            ->sort()
            ->reverse()
            ->take(100)  // TODO: receber esse parâmetro da interface
            ->map(fn (int $wordCount, string $key) => ['x' => $key, 'value' => $wordCount])
            ->values()
            ->toJson();

        return view('pages.report.news_tagcloud', compact('reportJson', 'request'));
    }
}
