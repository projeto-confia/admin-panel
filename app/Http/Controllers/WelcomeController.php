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
    private function graph_top_users_ics(Request $request)
    {
        $number_top_users = $request->inputTopUsers;
        $data_top_users = DB::select('select * from detectenv.get_top_users_which_shared_most_fake_news_ics(?);', array($number_top_users));
        
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

    public function show(Request $request)
    {
        $loggedUser = auth()->user()->name;  
        $json_top_users = $this->graph_top_users_ics($request);
        $total_news = $this->get_total_news();

        // dd($this->get_total_news_to_be_checked());

        return view('welcome', compact('loggedUser', 'json_top_users', 'total_news'));
    }

    // select * from
	// (select detectenv.social_media_account.id_account_social_media, detectenv.social_media_account.screen_name, 
	//  count(detectenv.news.classification_outcome) as total_news,
	//  count(detectenv.news.classification_outcome) filter (where detectenv.news.classification_outcome = true) as total_fake_news,
	//  count(detectenv.news.classification_outcome) filter (where detectenv.news.classification_outcome = false) as total_not_fake_news
	// from detectenv.post
	// inner join detectenv.social_media_account
	//  	on detectenv.post.id_social_media_account = detectenv.social_media_account.id_social_media_account
	// inner join detectenv.news
	//  	on detectenv.post.id_news = detectenv.news.id_news
	// group by
	// 	detectenv.social_media_account.id_account_social_media, detectenv.social_media_account.screen_name) tbl
    // order by tbl.total_news desc
}