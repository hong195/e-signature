<?php

namespace App\Listeners;

use App\Enums\UserStatus;
use App\Events\UserUpdated;
use App\Exceptions\SynchronizationException;
use App\Models\Traits\CompanyToken;
use App\Services\SyncService\Interfaces\SynchronizerServiceInterface;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class ReSyncUser
{
    use CompanyToken;

    /**
     * @var string
     */
    private $url;

    public function __construct()
    {
        $this->url = config('yandex.connect.directory_api.endpoint') . '/users';
    }

    /**
     * Handle the event.
     *
     * @param UserUpdated $payload
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws SynchronizationException
     */
    public function handle(UserUpdated $payload)
    {
        $token = $this->getCompanyToken($payload->user->department->company_id);

        if (!$token) {
            return;
        }

        $syncService = app()->make(SynchronizerServiceInterface::class, ['url' => $this->url, 'token' => $token]);

        $dataToSync = [
            'name' => [
                'first' => $payload->user->name,
                'last' => $payload->user->surname,
            ],
            'department_id' => $payload->user->department->import_id,
            'is_dismissed' => $payload->user->status === UserStatus::DISMISSED
        ];


        if ($payload->password) {
            $dataToSync['password'] = $payload->password;
            $payload->user->password = $payload->password;
        }

        try {
            $syncService->reSync($payload->user->import_id, $dataToSync);

            if ($payload->user->isDirty()) {
                $payload->user->save();
            }

        } catch (SynchronizationException $e) {
            report($e);
            throw $e;
        }
    }
}
