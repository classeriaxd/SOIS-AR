<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Auth\Authenticatable;

class AutoLoginController extends Controller
{

    public function login($id,$key)
    {
        $string = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $str_arr = explode ("/", $string); 
        $userID = $str_arr[5];
        $key = $str_arr[7];

        $s = 1;

        $userData = DB::table('sois_gates')->where('user_id','=',$userID)->where('gate_key','=',$key)->where('is_logged_in','=','1')->first();
        $userData2 = DB::table('sois_gates')->where('user_id','=',$userID)->where('gate_key','=',$key)->where('is_logged_in','=','1')->get();

        $userDataCount = count($userData2);

        if ($userDataCount == 1) {

            $KeyID = $userData->user_id;
            Auth::loginUsingId($KeyID);
            return redirect('/home');
        }

        else
        {
            return redirect("/");
        }
        
        $selected_key = DB::table('sois_gates')->get();
    }
}
