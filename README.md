# Laravel reCAPTCHA
===
reCAPTCHA v2 and Invisible reCAPTCHA for Laravel

## Installation
```bash
composer require daikazu/laravel-recaptcha
```
## Setup
*NOTE* This package supports Laravel 5.5 auto-discovery, so you can skip the setup if you are using 5.5 and above.

### LARAVEL 5





## Configuration

Public Config File `recaptcha.php`
```ssh
php artisan vendor:publish --provider="Daikazu\LaravelRecaptcha\ReCaptchaServiceProvider"

```
Add your `RECAPTCHA_SECRET` and `RECAPTCHA_SITEKEY` into your `.env` file:

```ssh
RECAPTCHA_SECRET=secret-key
RECAPTCHA_SITEKEY=site-key
```
(You can obtain them from [here](https://www.google.com/recaptcha/admin))

## Usage
