<?php


namespace App\Services\Yandex;


use App\Services\HttpClient\Response\ResponseInterface;

interface SyncApiInterface
{
    public function storeResource(array $data) : ResponseInterface;

    public function deleteResource(int $resourceId) : ResponseInterface;

    public function getResourcesList(array $options) : ResponseInterface;

    public function updateResource(int $id, array $data) : ResponseInterface;
}
