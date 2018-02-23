<?php

namespace Daikazu\LaravelRecaptcha\Facades;

use Illuminate\Support\Facades\Facade;

class ReCaptchaFacade extends Facade
{
    /**
     * Get Registered name of component
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'recaptcha';
    }
}