<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use App\Models\News;
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
        // $reportJson = News::query()
        //     ->select('text_news')
        //     ->where('id_news', '>', 600)
        //     ->whereNotNull('classification_outcome')
        //     ->whereNull('ground_truth_label')
        //     ->when(
        //         $request->start_date,
        //         fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
        //     )
        //     ->when(
        //         $request->end_date,
        //         fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
        //     )
        //     ->get()
        //     ->flatMap(function (News $news) use($stopWords) {
        //         $words = preg_split('/[^-\w\']+/', $news->text_news, -1, PREG_SPLIT_NO_EMPTY);
        //         $words = array_map('strtolower', $words);
        //         return array_diff($words, $stopWords);
        //     })
        //     ->countBy()
        //     ->sort()
        //     ->reverse()
        //     ->take(100)  // TODO: receber esse parâmetro da interface
        //     ->map(fn (int $wordCount, string $key) => ['x' => $key, 'value' => $wordCount])
        //     ->values()
        //     ->toJson();

        $data = [
            "labels" => ['12/02/2021', '13/02/2021', '14/02/2021', '15/02/2021', '16/02/2021', '17/02/2021'],
            "detected_fake" => [12, 19, 3, 12, 19, 3],
            "actual_fake" => [11, 17, 1, 12, 13, 3]
        ];

        $data_json = json_encode($data);

        // return view('pages.report.news_tagcloud', compact('reportJson', 'request'));
        return view('pages.report.news_actual_detected', compact('data_json', 'request'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
