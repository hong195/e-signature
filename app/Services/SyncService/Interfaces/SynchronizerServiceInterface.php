<?php


namespace App\Services\SyncService\Interfaces;

interface SynchronizerServiceInterface
{
    public function sync(array $data);

    public function deSync(int $resourceId);

    public function reSync(int $id, array $data);
}
