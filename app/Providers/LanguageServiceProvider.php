<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class LanguageServiceProvider extends ServiceProvider
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

        View::composer(['layout.main_partials.header', 'layout.client'], 'App\Http\View\Composers\LayoutComposer');


		// View::composer(
		// 	'layout.main', 'App\Http\View\Composers\LayoutComposer'
		// );
        // vendor / translation / languages / create.blade
    }
}
