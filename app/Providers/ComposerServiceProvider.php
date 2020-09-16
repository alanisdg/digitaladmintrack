<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use View;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['home'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['home2'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['reports'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['reportesgeocercas'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['tools'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['users.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['clients.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['drivers.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['routes.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['travels.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['locations.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['devices.*'],'App\Http\ViewComposers\HeaderComposer');
        View::composer(['geofences.*'],'App\Http\ViewComposers\HeaderComposer');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
