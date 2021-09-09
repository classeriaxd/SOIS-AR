<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;

use App\Models\User;
use App\Models\PositionTitle;
use App\Models\Notification;

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
        // Load Notifications on all Controllers
        View::composer('*', function ($view) {
            if (Auth::check() && $user_id = Auth::user()->user_id) 
            {
                // Load Notifications on all Controllers
                $notifications = Notification::where('user_id', $user_id)
                    ->whereRaw('created_at >= CURDATE() AND created_at < CURDATE() + INTERVAL 1 DAY')
                    ->get();
                $view->with('notifications', $notifications);
            }
        });

        Blade::if('position_title', function ($position_title) {
            $allowedOfficers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation', 'President'];
            $isAuth = false;
            $positionExists = false;
            if (Auth::check()) 
            {
                if ($position_title == 'Member')
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
                else if ($position_title == 'Officer')
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
            }

            if ( $positionExists )
                $isAuth = true;
        return $isAuth;
        });
    }
}
