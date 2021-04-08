<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\News;


class WelcomeController extends Controller
{
    private function graph_top_users_fake_not_fake(Request $request, $fake=true)
    {
        $number_top_users = $request->inputTopUsers;

        $data_top_users = $fake ? 
            DB::select('select * from detectenv.get_top_users_which_shared_news_ics() order by rate_fake_news desc offset 105 limit ?;', array($number_top_users)) :
            DB::select('select * from detectenv.get_top_users_which_shared_news_ics() order by rate_not_fake_news desc offset 325 limit ?;', array($number_top_users));

        # pega as chaves dos dados recuperados.
        $keys = array_keys(json_decode(json_encode($data_top_users[0]), true));
        $values = array();

        for ($i=0; $i < count($data_top_users); $i++) 
        { 
            $user = $data_top_users[$i];

            for ($j=0; $j < count($keys); $j++) 
            { 
                $key = $keys[$j];
                
                if (!array_key_exists($key, $values)) {
                    $values[$key] = array();
                }   

                array_push($values[$key], $user->$key);

                if ($key == "screen_name" && is_null($user->$key)) {
                    $values[$key][$i] = $values['id_account_social_media'][$i];
                }
            }
        }

        return json_encode($values);
    }

    private function get_total_news()
    {
        $total_news = News::all()->count();
        return $total_news;
    }

    private function get_total_news_predicted_ics()
    {
        return News::all()->whereNotNull('classification_outcome')->count();
    }

    private function get_total_news_checked()
    {
        return News::all()->whereNotNull('ground_truth_label')->count();
    }

    private function get_total_news_to_be_checked()
    {
        return News::all()->whereNull('ground_truth_label')->count();
    }

    private function get_qtd_news_corrected_predicted_ics()
    {
        $news_predicted_ics_with_checking = News::all()->whereNotNull('classification_outcome')->whereNotNull('ground_truth_label');
        $qtd_news_corrected_classified = 0;

        foreach ($news_predicted_ics_with_checking as $news) 
        {
            if ($news["classification_outcome"] == $news["ground_truth_label"]) {
                $qtd_news_corrected_classified++;
            }
        }
        return $qtd_news_corrected_classified;
    }

    public function show(Request $request)
    {
        $json_top_fake_users = $this->graph_top_users_fake_not_fake($request);
        $json_top_not_fake_users = $this->graph_top_users_fake_not_fake($request, false);
        $total_news = $this->get_total_news();
        $total_news_predicted = $this->get_total_news_predicted_ics();
        $total_news_checked = $this->get_total_news_checked();
        $qtd_news_corrected_classified = $this->get_qtd_news_corrected_predicted_ics();
        $total_news_to_be_checked = $this->get_total_news_to_be_checked();

        return view('welcome', compact('json_top_fake_users', 'json_top_not_fake_users', 'total_news', 'total_news_predicted', 
                                       'total_news_checked', 'total_news_to_be_checked', 'qtd_news_corrected_classified'));
    }
}