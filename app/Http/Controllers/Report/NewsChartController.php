<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class NewsChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
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
        // ->get();

        $data = [
            "labels" => ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
            "data" => [12, 19, 3, 5, 2, 3]
        ];

        return view('pages.report.news_chart')->with(['data' => json_encode($data)]);
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
