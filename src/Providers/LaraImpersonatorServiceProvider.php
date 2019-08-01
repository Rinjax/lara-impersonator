<?php

namespace Rinjax\LaraImpersonator\Providers;

use Illuminate\Support\ServiceProvider;
use Rinjax\LaraImpersonator\Http\Middleware\ImpersonateMiddleware;

class LaraImpersonatorServiceProvider extends ServiceProvider
{

    public function boot()
    {
        if(config('impersonator.register_routes')) $this->loadRoutesFrom(__DIR__ . '/../Http/Routes/routes.php');

        $this->app['router']->aliasMiddleware('impersonate', ImpersonateMiddleware::class);

        $this->app['router']->pushMiddlewareToGroup('web', ImpersonateMiddleware::class);

        $this->publishes([
            __DIR__.'/../Config/impersonator.php' => config_path('impersonator.php')
        ], 'impersonator');

        $this->registerBladeDirectives();
    }

    public function register()
    {

    }

    /**
     * Register custom blade directives
     */
    protected function registerBladeDirectives()
    {
        /**
         * Custom blade directive for if the user is currently impersonating.
         */
        \Blade::if('ifImpersonating', function(){
            return (session()->has('impersonate'));
        });


        /**
         * Custom blade directive for if the user can impersonate other users.
         */
        \Blade::if('canImpersonate', function(){
            return \Auth::user()->canImpersonate();
        });


        /**
         * Custom blade directive for if the user can be impersonated
         */
        \Blade::if('canBeImpersonated', function($user){
            return $user->canBeImpersonated();
        });
    }
}