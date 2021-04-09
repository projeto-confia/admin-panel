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
            )
            ->when(
                $request->end_date,
                fn($query) => $query->whereDate('datetime_publication', '<=', $request->end_date),
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
