# Laravel reCAPTCHA
## reCAPTCHA v2 and Invisible reCAPTCHA for Laravel
Easily add Google's V2 and Invisable reCaptcha to your forms;

This code is borrowed heavily from [anhskohbo/no-captcha](https://github.com/anhskohbo/no-captcha)

## Installation
```bash
composer require daikazu/laravel-recaptcha
```
## Setup
*NOTE* This package supports Laravel 5.5 auto-discovery, so you can skip the setup if you are using 5.5 and above.
## LARAVEL 5
### Configuration
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

#### Initialize javascript source:

With default options :

```php
 {!! ReCaptcha::renderJs() !!}
```

With [language support](https://developers.google.com/recaptcha/docs/language) or [onloadCallback](https://developers.google.com/recaptcha/docs/display#explicit_render) option :

```php
 {!! ReCaptcha::renderJs('fr', true, 'recaptchaCallback') !!}
```

### Display reCAPTCHA V2

```php
{!! ReCaptcha::displayWidget() !!}
```

With [custom attributes](https://developers.google.com/recaptcha/docs/display#render_param) (theme, size, callback ...) :

```php
{!! ReCaptcha::displayWidget(['data-theme' => 'dark']) !!}
```

### Display Invisible reCAPTCHA button

```php
{!! ReCaptcha::displayButton( 'Button Text', ['data-callback' => 'onFormSubmit', 'class' => 'button is-info']) !!}
```

### Validation
Add `'g-recaptcha-response' => 'required|recaptcha'` to to validation rules array;
```php
$validate = Validator::make(Input::all(), [
	'g-recaptcha-response' => 'required|recaptcha'
]);
```
Then check for reCAPTCHA errors in the form:
```php
@if ($errors->has('g-recaptcha-response'))
    <span class="help-block">
        <strong>{{ $errors->first('g-recaptcha-response') }}</strong>
    </span>
@endif
```
## Testing

Comming soon!









