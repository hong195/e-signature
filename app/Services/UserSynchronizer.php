<?php


namespace App\Services;


use App\Exceptions\MissingTokenException;
use App\Exceptions\SynchronizationException;
use App\Models\Traits\CompanyToken;
use App\Models\User;
use App\Services\Yandex\SyncApiInterface;

class UserSynchronizer
{
    use CompanyToken;

    private $requester;

    private $syncService;

    private $user;

    private $data;

    /**
     * UserSynchronizer constructor.
     * @param SyncApiInterface $syncService
     * @param User $user
     */
    public function __construct(SyncApiInterface $syncService, User $user)
    {
        $this->syncService = $syncService;
        $this->user = $user;
    }

    /**
     * @param array $dataToSync
     * @return HttpClient\Response\ResponseInterface
     * @throws MissingTokenException
     * @throws SynchronizationException
     */
    public function sync(array $dataToSync): HttpClient\Response\ResponseInterface
    {
        if (!$this->user->wasRecentlyCreated && !$this->user->import_id) {
            throw new SynchronizationException('Impossible to sync user without import id');
        }

        $companyId = $this->user->department->company->id;
        $token = $this->getCompanyToken($companyId);

        if (!$token) {
            throw new MissingTokenException('No token provided for api request');
        }

        $this->syncService->setToken($token);

        return $this->user->wasRecentlyCreated
            ? $this->syncService->storeResource($dataToSync)
            : $this->syncService->updateResource($this->user->import_id, $dataToSync);
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
