<?php

namespace Daikazu\LaravelRecaptcha;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Symfony\Component\HttpFoundation\Request;


class ReCaptcha
{
    const CLIENT_API = 'https://www.google.com/recaptcha/api.js';
    const VERIFY_URL = 'https://www.google.com/recaptcha/api/siteverify';

    protected $secret;

    protected $siteKey;

    protected $http;

    protected $verifiedResponses = [];

    public function __construct($secret, $siteKey, $options = [])
    {
        $this->secret = $secret;
        $this->siteKey = $siteKey;
        $this->http = new Client($options);
    }


    public function displayWidget($attributes = [])
    {
        $attributes['data-sitekey'] = $this->siteKey;
        return '<div class="g-recaptcha"' . $this->buildAttributes($attributes) . '></div>';

    }

    public function displayButton($buttonText = '', $attributes = [])
    {
        $attributes['data-sitekey'] = $this->siteKey;

        $classes = 'g-recaptcha';
        if (isset($attributes['class'])) {
            $classes .= ' ' . $attributes['class'];

            unset($attributes['class']);
        }

        return '<button class="' . $classes . '"' . $this->buildAttributes($attributes) . '>' . $buttonText . '</button>';
    }


    public function renderJs($lang = null, $callback = false, $onLoadClass = 'onloadCallBack')
    {
        return '<script src="' . $this->getJsLink($lang, $callback, $onLoadClass) . '" async defer></script>';
    }

    public function verifyResponse($response, $clientIp = null)
    {
        if (empty($response)) {
            return false;
        }
        // Return true if response already verfied before.
        if (in_array($response, $this->verifiedResponses)) {
            return true;
        }
        $verifyResponse = $this->sendRequestVerify([
            'secret'   => $this->secret,
            'response' => $response,
            'remoteip' => $clientIp,
        ]);
        if (isset($verifyResponse['success']) && $verifyResponse['success'] === true) {
            // A response can only be verified once from google, so we need to
            // cache it to make it work in case we want to verify it multiple times.
            $this->verifiedResponses[] = $response;
            return true;
        } else {
            return false;
        }
    }


    public function verifyRequest(Request $request)
    {
        return $this->verifyResponse(
            $request->get('g-recaptcha-response'),
            $request->getClientIp()
        );
    }


    private function getJsLink($lang = null, $callback = false, $onLoadClass = 'onloadCallBack')
    {
        $client_api = static::CLIENT_API;
        $params = [];
        $callback ? $this->setCallBackParams($params, $onLoadClass) : false;
        $lang ? $params['hl'] = $lang : null;
        return $client_api . '?' . http_build_query($params);
    }

    protected function setCallBackParams(&$params, $onLoadClass)
    {
        $params['render'] = 'explicit';
        $params['onload'] = $onLoadClass;
    }


    protected function sendRequestVerify(array $query = [])
    {
        try {
            $response = $this->http->request('POST', static::VERIFY_URL, [
                'form_params' => $query,
            ]);
        } catch (GuzzleException $e) {

        }
        return json_decode($response->getBody(), true);
    }


    protected function buildAttributes($attributes)
    {
        $html = [];

        foreach ($attributes as $key => $value) {
            $html[] = $key . '="' . $value . '"';
        }

        return count($html) ? ' ' . implode(' ', $html) : '';

    }


}
