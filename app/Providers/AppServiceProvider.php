<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Session;

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
        //get avatar from storage
        View::composer('*', function ($view) {
            $avatar = "";
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->avatar != null) {
                    $avatar = Storage::disk('spaces')->temporaryUrl(
                        $user->avatar,
                        Carbon::now()->addMinutes(5)
                    );
                }
                $view->with('avatar', $avatar);
            }
        });

        Paginator::useBootstrapFour();
        config(['app.locale' => 'id']);
        \Carbon\Carbon::setLocale('id');
    }
}
