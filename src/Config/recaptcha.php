<?php

return [
    'secret_key' => env('RECAPTCHA_SECRET'),
    'site_key'   => env('RECAPTCHA_SITEKEY'),
    'options'    => [
        'timeout' => '2',
    ],
];
