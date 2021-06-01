<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $news = News::query()
            ->when(
                $request->text_news,
                fn($query) => $query->where('text_news', 'ilike', "%{$request->text_news}%")
            )
            ->when(
                in_array($request->ground_truth_label, [0, 1]) && $request->ground_truth_label !== '*',
                fn($query) => $query->where('ground_truth_label', !$request->ground_truth_label),
                fn($query) => $query->whereNotNull('ground_truth_label'),
            )
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
            )
            ->paginate()
            ->withQueryString();


        return view('pages.report.news', compact('news', 'request'));
    }
}
