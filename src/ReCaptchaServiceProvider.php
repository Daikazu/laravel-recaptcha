<?php

namespace Daikazu\LaravelRecaptcha;

use Illuminate\Support\ServiceProvider;

class ReCaptchaServiceProvider extends ServiceProvider
{


    protected $defer = false;


    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $app = $this->app;

        $this->bootConfig();

        $app['validator']->extends('recaptcha', function ($attributes, $value) use ($app) {
            return $app['recaptcha']->verifyResponse($value, $app['request']->getClientIp());
        });

        if ($app->bound('form')) {
            $app['form']->macro('recaptcha', function ($attributes = []) use ($app) {
                return $app['recaptcha']->display($attributes, $app->getLocale());
            });
        }

    }


    protected function bootConfig()
    {
        $path = __DIR__ . '/config/recaptcha.php';
        $this->mergeConfigFrom($path, 'recaptcha');
        if (function_exists('config_path')) {
            $this->publishes([$path => config_path('recaptcha.php')]);
        }
    }


    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('recaptcha', function ($app) {
            return new Recaptcha(
                $app['config']['recaptcha.secret'],
                $app['config']['recaptcha.sitekey'],
                $app['config']['recaptcha.options']
            );
        });
    }


    public function provides()
    {
        return ['recaptcha'];
    }


}