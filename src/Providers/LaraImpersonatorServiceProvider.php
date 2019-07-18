<?php

namespace Rinjax\LaraImpersonator\Providers;

use Illuminate\Support\ServiceProvider;
use Rinjax\LaraImpersonator\Middleware\ImpersonateMiddleware;

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
         * Custom blade direct for if the user is currently impersonating.
         */
        \Blade::directive('ifImpersonating', function(){
            return "<?php if (session()->has('impersonate')): ?>";
        });
        \Blade::directive('endImpersonating', function(){
            return '<?php endif; ?>';
        });


        /**
         * Custom blade direct for if the user can impersonate other users.
         */
        \Blade::directive('canImpersonate', function(){
            return "<?php if (\Auth::user()->canImpersonate()): ?>";
        });
        \Blade::directive('endImpersonate', function(){
            return '<?php endif; ?>';
        });
    }
}