<?php

namespace App\Providers;

use App\Models\GeneralSetting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        if (Schema::hasTable('general_settings')){

            $general_settings = GeneralSetting::latest()->first();
            
            // Procedure - 1
            // view()->composer('layout.main_partials.header', function ($view) use ($generalSetting) {
            //     $view->with('generalSetting', $generalSetting);
            // });

            // Procedure - 2
            view()->composer([
                'layout.main',
                'layout.main_partials.header',
                'layout.main_partials.footer',
                'projects.invoices.show',
                'dashboard',
                'layout.client',
                'frontend.Layout.navigation',
                'documentation.index',
                'vendor.translation.layout',

                'vendor.translation.languages.create'
            ], function ($view) use ($general_settings) {
                $view->with('general_settings', $general_settings);
            });
        }
    }
}



