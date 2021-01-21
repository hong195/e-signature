<?php


namespace App\Services\SyncService\Yandex;

use App\Services\SyncService\SyncInterface;
use Illuminate\Support\Facades\Http;

class YandexService implements SyncInterface
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

    public function __construct(string $url = null, string $token = null)
    {
        $this->request = new Http();
        $this->url = $url;
        $this->token = $token;
        $this->headers['Authorization'] = "OAuth {$this->token}";
    }

    public function getResourcesList(array $options): \Illuminate\Http\Client\Response
    {
        $this->headers['Content-Type'] = 'application/json';

        return $this->make()->get($this->url, $options);
    }

    public function storeResource(array $data): \Illuminate\Http\Client\Response
    {
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->post($this->url, $data);
    }

    public function updateResource(int $id, array $data): \Illuminate\Http\Client\Response
    {
        $updateUrl = "{$this->url}/{$id}";
        $this->headers['Content-type'] = 'application/json';

        return $this->make()->patch($updateUrl, $data);
    }

    public function deleteResource(int $id): \Illuminate\Http\Client\Response
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
