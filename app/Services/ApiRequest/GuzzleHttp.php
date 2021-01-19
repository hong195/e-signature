<?php


namespace App\Services\ApiRequest;

use Illuminate\Support\Facades\Http;

class GuzzleHttp implements ApiRequestInterface, RequestHeadersInterface
{
    /**
     * @var Http
     */
    private $http;

    public function __construct()
    {
        $this->http = (new Http());
    }

    public function get(string $url, array $data): \Illuminate\Http\Client\Response
    {
        return $this->http::get($url, $data);
    }

    public function post(string $url, array $data): \Illuminate\Http\Client\Response
    {
        return $this->http::post($url, $data);
    }

    public function put(string $url, array $data): \Illuminate\Http\Client\Response
    {
        return $this->http::put($url, $data);
    }

    public function patch(string $url, array $data): \Illuminate\Http\Client\Response
    {
        return $this->http::patch($url, $data);
    }

    public function delete(string $url): \Illuminate\Http\Client\Response
    {
        return $this->http::delete($url);
    }

    public function setHeaders(array $headers): \Illuminate\Http\Client\PendingRequest
    {
        return $this->http::withHeaders($headers);
    }
}
