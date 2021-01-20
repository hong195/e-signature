<?php

namespace App\Observers;

use App\Models\Traits\CompanyToken;
use App\Models\User;
use App\Services\UserSynchronizer;
use App\Services\Yandex\SyncApiInterface;

class UserSavedObserver
{
    use CompanyToken;
    /**
     * @var SyncApiInterface
     */
    private $syncService;

    public function __construct(UserSynchronizer $syncService)
    {
        $this->syncService = $syncService;
    }

    public function saved(User $user)
    {
        // todo sync with third party service
        $user->saveQuietly();
    }
}
