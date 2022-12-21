<?php declare(strict_types=1);

namespace App\Check;

use GuzzleHttp\Client;
class Varnish implements CheckInterface
{
    public function ping(): bool
    {
        $httpClient = new Client();
        $response = $httpClient->request('GET', 'http://varnish/', ['http_errors' => false]);
        return $response ? true : false;
    }

    public function version(): string
    {
        $httpClient = new Client();
        $response = $httpClient->request('GET', 'http://varnish/', ['http_errors' => false]);
        $headers = $response->getHeaders();
        return $headers['Via'][0];
    }

    public function getBackendServer(): string
    {
        $httpClient = new Client();
        $response = $httpClient->request('GET', 'http://varnish/', ['http_errors' => false]);
        $headers = $response->getHeaders();
        return $headers['Server'][0];
    }
}