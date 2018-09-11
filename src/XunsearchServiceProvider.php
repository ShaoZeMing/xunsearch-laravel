<?php
namespace ShaoZeMing\LaravelXunsearch;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Application as LaravelApplication;
use Laravel\Lumen\Application as LumenApplication;
use ShaoZeMing\Xunsearch\XunsearchService;

/**
 * Class XunsearchServiceProvider
 * User: ZeMing Shao
 * Email: szm19920426@gmail.com
 * @package ShaoZeMing\LaravelXunsearch
 */
class XunsearchServiceProvider extends ServiceProvider
{

    protected $defer = true;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        $source = realpath(dirname(__DIR__).'/config/xunsearch.php');

        if ($this->app instanceof LaravelApplication && $this->app->runningInConsole()) {
            $this->publishes([$source => config_path('xunsearch.php')]);
        } elseif ($this->app instanceof LumenApplication) {
            $this->app->configure('xunsearch');
        }
        $this->mergeConfigFrom($source, 'xunsearch');

    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        defined('XS_APP_ROOT') || define('XS_APP_ROOT', config_path());
        $this->app->singleton(XunsearchService::class, function ($app) {
            return new XunsearchService();
        });
        $this->app->alias(XunsearchService::class, 'xunsearch');
    }

    public function provides()
    {
        return [XunsearchService::class,'xunsearch'];
    }
}
