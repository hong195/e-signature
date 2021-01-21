<?php


namespace App\Services\SyncService;


use App\Exceptions\MissingTokenException;
use App\Exceptions\SynchronizationException;
use App\Models\Traits\CompanyToken;
use App\Models\User;

class UserSync implements UserSyncInterface
{
    use CompanyToken;

    private $requester;

    private $syncService;

    private $user;

    private $data;

    private $url;

    /**
     * UserSynchronizer constructor.
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->user = $user;
        $this->url = config('yandex.api_endpoint') . '/users';
    }

    /**
     * @param array $dataToSync
     * @return array
     * @throws MissingTokenException
     * @throws SynchronizationException
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function sync(array $dataToSync) : array
    {
        if (!$this->user->wasRecentlyCreated && !$this->user->import_id) {
            throw new SynchronizationException('Impossible to sync user without import id');
        }

        $token = $this->getCompanyTokenViaUser();

        if (!$token) {
            throw new MissingTokenException('No token provided for api request');
        }

        try {
            $syncService = app()->make(SyncInterface::class, ['url' => $this->url, 'token' => $token]);
        }catch (\Illuminate\Contracts\Container\BindingResolutionException $e) {
            report($e);
            throw($e);
        }

        $response = $this->user->wasRecentlyCreated
            ? $syncService->storeResource($dataToSync)
            : $syncService->updateResource($this->user->import_id, $dataToSync);

        if ($response->clientError()) {
            $response->throw();
        }

        return $response->json();
    }

    /**
     * @return string|null
     */
    private function getCompanyTokenViaUser()
    {
        $companyId = $this->user->department->company->id;
        return  $this->getCompanyToken($companyId);
    }
}
