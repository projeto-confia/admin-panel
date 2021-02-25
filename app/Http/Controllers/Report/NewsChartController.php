<?php

namespace App\Http\Controllers\Report;

use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $reportData = News::query()
            ->select(News::raw('datetime_publication::DATE'), 'classification_outcome', News::raw('count(*) as total'))
            ->where('id_news', '>', 600)
            ->whereNotNull('classification_outcome')
            ->whereNull('ground_truth_label')
            ->when(
                $request->start_date,
                fn($query) => $query->whereDate('datetime_publication', '>=', $request->start_date),
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
            )
            ->groupBy(News::raw('datetime_publication::DATE'), 'classification_outcome')
            ->orderby('datetime_publication')
            ->orderby('classification_outcome')
            ->get()
            ->reduce(function ($acc, $item) {
                $label = $item->datetime_publication->format('d/m/Y');
                $hasLabel = (bool) Arr::first($acc['labels'], fn($it) => $it == $label);
                
                if (!$hasLabel) {
                    array_push($acc['labels'], $label);
                }

                $key = $item->classification_outcome ? 'data_true' : 'data_false';
                array_push($acc[$key], $item->total);

                return $acc;
            }, [
                'labels' => [],
                'data_true' => [],
                'data_false' => []
            ]);

        // $data = [
        //     "labels" => ['12/02/2021', '14/02/2021', '20/02/2021', '21/02/2021', '22/02/2021', '23/02/2021'],
        //     "data_true" => [12, 19, 3, 12, 19, 3],
        //     "data_false" => [20, 15, 8, 12, 19, 3]
        // ];

        $reportJson = json_encode($reportData);

        return view('pages.report.news_chart', compact('reportJson', 'request'));
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
