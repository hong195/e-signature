<?php

namespace App\Listeners;

use App\Events\UserSaved;
use App\Services\PasswordGenerator;
use App\Services\SyncService\UserSyncInterface;

class UserSavedListener
{
    /**
     * @var PasswordGenerator
     */
    private $passwordGenerator;

    public function __construct(PasswordGenerator $passwordGenerator)
    {
        $this->passwordGenerator = $passwordGenerator;
    }

    public function handle(UserSaved $payload): void
    {
        try {
            $syncService = app()->make(UserSyncInterface::class, ['user' => $payload->user]);
        } catch (\Exception $e) {
            report($e);
            throw $e;
        }

        $dataToSync = [
            'name' => [
                'first' => $payload->validatedUserData['name'],
                'last' => $payload->validatedUserData['surname'],
            ],
            'department_id' => $payload->user->department->import_id,
        ];

        if (array_key_exists('login', $payload->validatedUserData)) {
            $dataToSync['nickname'] = $payload->validatedUserData['login'];
        }

        if (array_key_exists('password', $payload->validatedUserData)) {
            $dataToSync['password'] = $payload->validatedUserData['password'];
        } else if ($payload->user->wasRecentlyCreated) {
            $dataToSync['password'] = $this->passwordGenerator->generate();
        }

        if (array_key_exists('password', $dataToSync)) {
            $payload->user->password  = bcrypt($dataToSync['password']);
        }

        $syncedData = $syncService->sync($dataToSync);

        $payload->user->contacts()->create([
            'name' => 'yandex_email',
            'value' => $syncedData['email']
        ]);

        $payload->user->import_id = $syncedData['id'];
        $payload->user->is_active = true;
        $payload->user->save();
    }
}
