<?php

namespace App\Providers;

//use App\Jobs\ReviewCalculate;
//use App\Models\Reviews;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Models\Options;
use Illuminate\Pagination\Paginator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Paginator::defaultView('sections.pagination');
        foreach (Options::all(['name', 'value']) as $config) {
            //config([$config['name'] => $config['value']]);
        }

//        Reviews::updated(function ($review) {
//            ReviewCalculate::dispatch($review);
//        });
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
