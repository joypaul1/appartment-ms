<?php

namespace App\Providers;

use App\Models\InvoicePrefix;
use App\Models\Item\Category;
use App\Models\QuickPage;
use App\Models\SiteInfo;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('*', function ($view)
        {
            if (!session('site_info')) {
                $siteInfo = SiteInfo::first()->toArray();
                session([ 'site_info' => $siteInfo ]);
            }
        });


    }
}
