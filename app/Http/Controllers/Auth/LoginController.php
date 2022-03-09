<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

use App\Services\DataLogServices\DataLogService;

class LoginController extends Controller
{
    use AuthenticatesUsers;
    protected $dataLogger;

    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->dataLogger = new DataLogService();
        session()->put('showLoginAlert', 1);
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected function authenticated(Request $request, $user)
    {
        // Redirect Super Admin Role
        if ( ($user->roles->pluck('role'))->containsStrict('Super Admin') )
        {
            $this->dataLogger->log($user->user_id, 'Super Admin Logged In.');
            return redirect()->route('admin.home');
        } 

        // Redirect Head of Student Services Role
        else if ( ($user->roles->pluck('role'))->containsStrict('Head of Student Affairs'))
        {
            $this->dataLogger->log(Auth::user()->user_id, 'Head of Student Affairs Logged In.');
            return redirect()->route('admin.home');
        } 

        // Redirect Directoe Role
        else if ( ($user->roles->pluck('role'))->containsStrict('Director'))
        {
            $this->dataLogger->log(Auth::user()->user_id, 'Director Logged In.');
            return redirect()->route('admin.home');
        } 

        // User | Officer | President | Other Admins 
        else
        {
            $this->dataLogger->log($user->user_id, 'User Logged In.');
            return redirect()->route('home');   
        }
            
    }
}
