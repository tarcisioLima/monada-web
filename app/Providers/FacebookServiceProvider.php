<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Facebook\Facebook;

class FacebookServiceProvider extends ServiceProvider
{

    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Facebook::class, function ($app){
            $config = config('services.facebook');
            return new Facebook([
                'appId' => $config['client_id'],
                'secret' => $config['client_secret'],
                'default_graph_version' => $config['default_graph_version'],
            ]);
        });
    }
}
