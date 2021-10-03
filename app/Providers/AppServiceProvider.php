<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

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
        // Bootstrap Paginator
        Paginator::useBootstrap();

        // Load Notifications on all Views
        View::composer('*', function ($view) {
            if (Auth::check()) 
            {
                $notifications = Notification::where('user_id', Auth::user()->user_id)
                    ->whereNull('read_at')
                    ->orderBy('read_at', 'ASC')
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->get();
                $notificationCount = Notification::where('user_id', Auth::user()->user_id)
                    ->whereNull('read_at')
                    ->count();
                    
                $view->with('notifications', $notifications);
                $view->with('notificationCount', $notificationCount);
            }
        });

        Blade::if('position_title', function ($position_title) {
            $allowedOfficers = ['Vice President for Research and Documentation', 'Assistant Vice President for Research and Documentation'];
            $presidentOfficerTitle = 'President';
            $isAuth = false;
            $positionExists = false;
            if (Auth::check()) 
            {
                $user_position_titles = Auth::user()->positionTitles->pluck('position_title');
                if ($position_title == 'Member')
                {
                    foreach($user_position_titles as $title)
                    {
                        if($position_title == $title)
                        {
                            $positionExists = true;
                        }
                    }
                }
                else if ($position_title == 'President')
                {
                    foreach($user_position_titles as $title)
                    {
                        if($title == $presidentOfficerTitle)
                            $positionExists = true;
                    }
                }
                else if ($position_title == 'Officer')
                {
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
