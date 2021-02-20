<?php

namespace App\Http\Controllers\Report;

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
        // $start_date = $request->get('start_date');
        // $end_date = $request->get('end_date');

        // $news = News::where('id_news', '>', 600)
        // ->when($start_date, function($query, $start_date){
        //     return $query->where('datetime_publication', '>=', $start_date);
        // })
        // ->when($end_date, function($query, $end_date){
        //     return $query->where('datetime_publication', '<=', $end_date);
        // })
        // ->get()
        // ->withQueryString();

        $data = [
            "labels" => ['12/02/2021', '14/02/2021', '20/02/2021', '21/02/2021', '22/02/2021', '23/02/2021'],
            "data_true" => [12, 19, 3, 12, 19, 3],
            "data_false" => [20, 15, 8, 12, 19, 3]
        ];

        $data_json = json_encode($data);

        return view('pages.report.news_chart', compact('data_json', 'request'));
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
