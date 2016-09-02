<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Topics;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $topicsLists = Topics::getTopicsLists();
        view()->share('topicsLists', $topicsLists);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
