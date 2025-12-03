<?php

namespace App\Utils;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Transbank\Utils\HttpClient;

class TransbankHttpClientNoSSL extends HttpClient
{
    protected function sendGuzzleRequest(
        string $method,
        string $url,
        array $headers,
        string|null $payload,
        int $timeout
    ): ResponseInterface {
        $request = new Request($method, $url, $headers, $payload);

        $client = new Client([
            'http_errors' => false,
            'timeout' => $timeout,
            'read_timeout' => $timeout,
            'connect_timeout' => $timeout,
            'verify' => false, // Deshabilitar verificación SSL para desarrollo
        ]);

        return $client->send($request);
    }
}
