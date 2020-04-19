<?php

namespace App\Telegram\Traits;

use GuzzleHttp\Exception\RequestException;

trait SendTelegramData
{
    public function sendTelegramData($route, $params = [], $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(['base_uri' => 'https://api.telegram.org/bot' . \Telegram::getAccessToken() . '/']);
        try {
            return (string)$client->request($method, $route, ['query' => $params])->getBody();
        }
        catch (RequestException $exception) {
            return (string)$exception->getResponse()->getBody();
        }
    }
}
