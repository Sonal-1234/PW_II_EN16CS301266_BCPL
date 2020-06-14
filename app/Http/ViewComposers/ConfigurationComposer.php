<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;

class ConfigurationComposer {

    public $movieList = [];

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct() {
        $this->movieList = [
            'Shawshank redemption',
            'Forrest Gump',
            'The Matrix',
            'Pirates of the Carribean',
            'Back to the future',
        ];
    }

    /**
     * Bind data to the view.
     *
     * @param View $view
     * @return void
     */
    public function compose(View $view) {
        $auth = auth()->user();
        $auth->role = ucfirst(strtolower(auth()->user()->authority->authority_name));
        $view->with('auth', $auth);
    }
}