<?php

namespace App\Http\Controllers;

use Auth;
use Str;
use Illuminate\Http\Request;

use App\Models\SOISGate;
use App\Services\DataLogServices\DataLogService;

class AutoLoginController extends Controller
{
    protected $dataLogger;

    /**
     * @param Integer $id, String $key
     * An autologin function that recieves requests from SOIS-HOMEPAGE
     * @return Redirect
     */ 
    public function login($id, $key)
    {
        $this->dataLogger = new DataLogService();

        // Checks if URL has SSL, then appends it along with Host URL and  Request URI to get the full URL
        $urlString = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        // Explode URL using "/" as separators
        $explodedString = explode ("/", $urlString); 

        // Get User ID from URL
        $userID = $explodedString[5];

        // Get Gate Key from URL
        $gateKey = $explodedString[7];

        $userData = SOISGate::where('user_id' , $userID)
            ->where('gate_key' ,$gateKey)
            ->where('is_logged_in' ,'1')
            ->first();

        // If the URL provided an existing ID, Key, and the user is logged-in in SOIS-Homepage... 
        if ($userData->isNotEmpty()) 
        {
            // Login User using ID
            Auth::loginUsingId($userData->user_id);

            // Redirect Logic for SOIS-AR

            // Redirect Super Admin Role
            if ( (Auth::user()->roles->pluck('role'))->containsStrict('Super Admin'))
            {
                $this->dataLogger->log(Auth::user()->user_id, 'Super Admin logged in from SOIS-Homepage.');
                $this->regenerateGateKey($userID, $gateKey);
                return redirect()->route('admin.home');
            } 

            // Redirect Head of Student Services Role
            else if ( (Auth::user()->roles->pluck('role'))->containsStrict('Head of Student Affairs'))
            {
                $this->dataLogger->log(Auth::user()->user_id, 'Head of Student Affairs logged in from SOIS-Homepage.');
                $this->regenerateGateKey($userID, $gateKey);
                return redirect()->route('admin.home');
            } 
    
            // Redirect User|Officer|President|Other Admins
            else
            {
                $this->dataLogger->log(Auth::user()->user_id, 'User logged in from SOIS-Homepage.');
                $this->regenerateGateKey($userID, $gateKey);
                return redirect()->route('home');   
            }
        }

        // If the key and user id is not found, abort connection
        abort(404);
    }

    /**
     * @param Integer $userID, String $gateKey
     * Function to regenerate a new Gate Key for each login of User from SOIS-Homepage
     */ 
    private function regenerateGateKey($userID, $gateKey)
    {   
        $newUUID = Str::uuid();
        while (SOISGate::->where('gate_key' ,$newUUID)->exists()) {
            $newUUID = Str::uuid();
        }

        SOISGate::where('user_id' , $userID)
            ->where('gate_key' ,$gateKey)
            ->update([
                'gate_key' => Str::uuid(),
            ]);
    }
}
