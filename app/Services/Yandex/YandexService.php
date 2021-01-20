<?php


namespace App\Services\Yandex;

use App\Services\HttpClient\Request\RequestInterface;
use App\Services\HttpClient\Response\ResponseInterface;
use Illuminate\Support\Facades\Http;

class YandexService implements SyncApiInterface, TokenInterface
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var string
     */
    private $url;

    private $token;

    private $headers = [];

    public function __construct(RequestInterface $request, string $url = null, string $token = null)
    {
        $this->request = $request;
        $this->url = $url;
        $this->token = $token;
    }

    public function getResourcesList(array $options): ResponseInterface
    {
        $this->headers['Content-Type'] = 'application/json';

        return $this->make()->get($this->url, $options);
    }

    public function storeResource(array $data): ResponseInterface
    {
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->post($this->url, $data);
    }

    public function updateResource(int $id, array $data): ResponseInterface
    {
        $updateUrl = "{$this->url}/{$id}";
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->patch($updateUrl, $data);
    }

    public function deleteResource(int $id): ResponseInterface
    {
        $deleteUrl = "{$this->url}/{$id}";
        return $this->make()->delete($deleteUrl);
    }

    protected function make()
    {
        if (!$this->token) {
            return $this->request;
        }

        return $this->request->setHeaders($this->headers);
    }

    public function setUrl(string $url): self
    {
        $this->url = $url;
        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;
        $this->headers['Authorization'] = "OAuth {$token}";

        return $this;
    }
}
