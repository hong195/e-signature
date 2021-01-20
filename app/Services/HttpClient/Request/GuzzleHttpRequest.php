<?php


namespace App\Services\HttpClient\Request;

use App\Services\HttpClient\Response\ResponseInterface;
use Illuminate\Support\Facades\Http;
use App\Services\HttpClient\Response\GuzzleHttpResponse;

class GuzzleHttpRequest implements RequestInterface, RequestHeadersInterface
{
    /**
     * @var Http
     */
    private $http;

    private $headers = [];

    public function __construct()
    {
        $this->http = (new Http());
    }

    public function get(string $url, array $data): ResponseInterface
    {
        return new GuzzleHttpResponse($this->make()->get($url, $data));
    }

    public function post(string $url, array $data): ResponseInterface
    {
        return new GuzzleHttpResponse($this->make()->post($url, $data));
    }

    public function put(string $url, array $data): ResponseInterface
    {
        return new GuzzleHttpResponse($this->make()->put($url, $data));
    }

    public function patch(string $url, array $data): ResponseInterface
    {
        return new GuzzleHttpResponse($this->make()->patch($url, $data));
    }

    public function delete(string $url): ResponseInterface
    {
        return new GuzzleHttpResponse($this->make()->delete($url));
    }

    protected function make(): \Illuminate\Http\Client\PendingRequest
    {
        return $this->http::withHeaders($this->headers);
    }

    public function setHeaders(array $headers): self
    {
        $this->headers = $headers;

        return $this;
    }
}
