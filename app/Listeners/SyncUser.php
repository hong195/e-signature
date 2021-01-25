<?php

namespace App\Listeners;

use App\Enums\UserStatus;
use App\Events\UserCreated;
use App\Exceptions\SynchronizationException;
use App\Models\Contact;
use App\Models\Traits\CompanyToken;
use App\Models\User;
use App\Notifications\WelcomeNotification;
use App\Services\PasswordGenerator;
use App\Services\SyncService\Interfaces\SynchronizerServiceInterface;
use Illuminate\Support\Facades\Notification;

class SyncUser
{
    use CompanyToken;

    /**
     * @var PasswordGenerator
     */
    private $passwordGenerator;
    /**
     * @var string
     */
    private $url;

    public function __construct(PasswordGenerator $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
        $this->url = config('yandex.connect.directory_api.endpoint') . '/users';
    }

    /**
     * @param UserCreated $payload
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws SynchronizationException
     */
    public function handle(UserCreated $payload): void
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
            'contacts' => [
                [
                    'type' => 'phone',
                    'value' => $payload->user->phone,
                    'label' => 'Мобильный телефон'
                ],
            ],
            'department_id' => $payload->user->department->import_id,
            'nickname' => $payload->user->nickname,
            'password' => $this->passwordGenerator->generate()
        ];

        try {
            $syncedData = $syncService->sync($dataToSync);

            Notification::route('mail', $payload->user->email)
                ->notify(new WelcomeNotification($syncedData['email'], $dataToSync['password']));

            $payload->user->password = bcrypt($dataToSync['password']);
            $payload->user->import_id = $syncedData['id'];
            $payload->user->status = UserStatus::ACTIVE;
            $payload->user->email = $syncedData['email'];
            $payload->user->save();

        } catch (SynchronizationException $e) {
            throw $e;
        }
    }
}
