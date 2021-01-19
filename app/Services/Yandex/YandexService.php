<?php


namespace App\Services\Yandex;

use App\Services\ApiRequest\ApiRequestInterface;
use Illuminate\Support\Facades\Http;


class YandexService
{
    /**
     * @var Http
     */
    private $request;
    /**
     * @var string
     */
    private $url;

    public function __construct(ApiRequestInterface $request, string $url, string $token)
    {
        $request->setHeaders([
            'Authorization' => "OAuth {$token}",
        ]);

        $this->request = $request;
        $this->url = $url;
    }

    public function index(array $options) : \Illuminate\Http\Client\Response
    {
        return $this->request->get($this->url, $options);
    }

    public function store(array $data): \Illuminate\Http\Client\Response
    {
        return $this->request->post($this->url, $data);
    }

    public function update(int $id,array $data): \Illuminate\Http\Client\Response
    {
        $updateUrl = "{$this->url}/{$id}";
        return $this->request->put($updateUrl, $data);
    }

    public function delete(int $id): \Illuminate\Http\Client\Response
    {
        $deleteUrl = "$this->url . $id";
        return $this->request->delete($deleteUrl);
    }
}
