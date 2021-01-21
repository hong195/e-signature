<?php


namespace App\Services\SyncService;

interface SyncInterface
{
    public function storeResource(array $data);

    public function deleteResource(int $resourceId);

    public function getResourcesList(array $options);

    public function updateResource(int $id, array $data);
}
