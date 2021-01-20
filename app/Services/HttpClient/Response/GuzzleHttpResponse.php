<?php


namespace App\Services\HttpClient\Response;
use  Illuminate\Http\Client\Response as ClientResponse;


class GuzzleHttpResponse implements ResponseInterface
{
    private $response;

    public function __construct(ClientResponse $response)
    {
        $this->response = $response;
    }

    public function isClientError(): bool
    {
        return $this->response->clientError();
    }

    public function isServerError(): bool
    {
        return $this->response->serverError();
    }

    public function isOk(): bool
    {
        return $this->response->ok();
    }

    public function isFailed(): bool
    {
        return $this->response->failed();
    }

    public function getBody(): string
    {
        return $this->response->body();
    }

    public function json(): array
    {
        return $this->response->json();
    }
}
