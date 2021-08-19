<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;

use App\Models\User;
use App\Models\PositionTitle;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::if('position_title', function ($position_title) {
            $allowedOfficers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation', 'President'];
            $isAuth = false;
            $positionExists = false;
            if (Auth::check() && $position_title == 'Member')
            {
                $user_position_titles = Auth::user()->positionTitles->pluck('position_title');
                foreach($user_position_titles as $title)
                {
                    if($position_title == $title)
                    {
                        $positionExists = true;
                    }
                }
            }
            else if (Auth::check() && $position_title == 'Officer')
            {
                $user_position_titles = Auth::user()->positionTitles->pluck('position_title');
                foreach($user_position_titles as $title)
                {
                    if(in_array($title, $allowedOfficers, true))
                    {
                        $positionExists = true;
                    }
                }
            }
            if ( Auth::check() && ($positionExists) )
                $isAuth = true;
        return $isAuth;
        });
    }
}
