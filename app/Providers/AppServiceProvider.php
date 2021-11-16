<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View;
use Illuminate\Pagination\Paginator;

use App\Models\User;
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

        // @role() @elserole() @else @endrole on Blade Views
        Blade::if('role', function ($role) {
            if (Auth::check())
            {
                if((Auth::user()->roles->pluck('role'))->containsStrict($role))
                    return true;
            }

            return false;
        });
    }
}
