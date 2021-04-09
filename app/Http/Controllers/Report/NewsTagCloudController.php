<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsTagCloudController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        // TODO: mover stopWords para arquivo
        $stopWords = ['o', 'd', 'das', 'e', 'a', 'os', 'as', 'em', 'no', 'com', 'de', 'eu', 'que', 'é', 'esse', 'https', 'co', 't', 'do', 'da'];

        $reportJson = News::query()
            ->select('text_news')
            ->whereNull('ground_truth_label')
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
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
