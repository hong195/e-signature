<?php


namespace App\Services\ResourceService;

use App\Services\ResourceService\Interfaces\ResourceServiceInterface;
use Illuminate\Support\Facades\Http;

class YandexResource implements ResourceServiceInterface
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

    public function __construct(string $url, string $token)
    {
        $this->request = new Http();
        $this->url = $url;
        $this->token = $token;
        $this->headers['Authorization'] = "OAuth {$this->token}";
    }

    public function get(array $options): \Illuminate\Http\Client\Response
    {
        $this->headers['Content-Type'] = 'application/json';

        return $this->make()->get($this->url, $options);
    }

    public function store(array $data): \Illuminate\Http\Client\Response
    {
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->post($this->url, $data);
    }

    public function update(int $id, array $data): \Illuminate\Http\Client\Response
    {
        $updateUrl = "{$this->url}/{$id}";
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->patch($updateUrl, $data);
    }

    public function delete(int $id): \Illuminate\Http\Client\Response
    {
        $deleteUrl = "{$this->url}/{$id}";
        return $this->make()->delete($deleteUrl);
    }

    /**
     * @return \Illuminate\Http\Client\PendingRequest|Http
     */
    protected function make()
    {
        if (!$this->token) {
            return $this->request;
        }

        return $this->request::withHeaders($this->headers);
    }
}
