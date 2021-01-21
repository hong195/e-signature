<?php


namespace App\Services\SyncService;


interface UserSyncInterface
{
    public function sync(array $dataToSync);
}
