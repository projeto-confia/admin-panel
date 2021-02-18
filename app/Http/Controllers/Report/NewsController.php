<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\News;

class NewsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $text = $request->get('text_news');
        $start_date = $request->get('start_date');
        $end_date = $request->get('end_date');
        $classification = $request->get('classification');

        switch ($classification) {
            case '1':
                $classification_filter = 'false';
                break;
            case '0':
                $classification_filter = 'true';
                break;
        }

        $news = News::where('id_news', '>', 600)
        ->when($text, function($query, $text){
            return $query->where('text_news', 'ilike', '%'.$text.'%');
        })
        ->when(isset($classification_filter), function($query, $classification_filter){
            return $query->where('classification_outcome', $classification_filter);
        }, function($query){
            return $query->whereNotNull('classification_outcome');
        })
        ->when($start_date, function($query, $start_date){
            return $query->where('datetime_publication', '>=', $start_date);
        })
        ->when($end_date, function($query, $end_date){
            return $query->where('datetime_publication', '<=', $end_date);
        })
        ->paginate(5)
        ->withQueryString();

        return view('pages.report.news')->with(['news' => $news, 'request' => $request]);
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
