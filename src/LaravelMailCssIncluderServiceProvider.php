<?php 
namespace Roywulms\LaravelMailCssIncluder;

use Illuminate\Support\ServiceProvider;

class LaravelMailCssIncluderServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['mailer']->getSwiftMailer()->registerPlugin(new ExternalCssPlugin());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Do nothing
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }
}
