<?php


namespace App\Services\ApiRequest;


interface ApiRequestInterface
{
    public function get(string $url, array $data);

    public function post(string $url, array $data);

    public function put(string $url, array $data);

    public function patch(string $url, array $data);

    public function delete(string $url);
}
