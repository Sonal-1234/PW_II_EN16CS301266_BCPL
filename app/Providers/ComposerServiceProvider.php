<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider {

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot() {
        view()->composer(
            'backend.*',
            'App\Http\ViewComposers\ConfigurationComposer'
        );
    }
}
