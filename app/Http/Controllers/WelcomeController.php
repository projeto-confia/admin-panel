<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Support\Arr;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;


class WelcomeController extends Controller
{
    public function show(Request $request)
    {
        $loggedUser = auth()->user()->name;
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

        $json_top_users = json_encode($values);
        return view('welcome', compact('loggedUser', 'json_top_users'));
    }
}