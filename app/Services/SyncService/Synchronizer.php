<?php


namespace App\Services\SyncService;


use App\Exceptions\SynchronizationException;
use App\Services\SyncService\Interfaces\SynchronizerServiceInterface;
use App\Services\ResourceService\Interfaces\ResourceServiceInterface;

final class Synchronizer implements SynchronizerServiceInterface
{
    /**
     * @var string
     */
    private $url;
    /**
     * @var string
     */
    private $token;

    private $syncService;

    /**
     * Synchronizer constructor.
     * @param string $url
     * @param string $token
     */
    public function __construct(string $url, string $token)
    {
        $this->url = $url;
        $this->token = $token;
        $this->syncService = app(ResourceServiceInterface::class, [
            'url' => $url,
            'token' => $token
        ]);
    }

    public function sync(array $dataToSync): array
    {
        $response = $this->syncService->store($dataToSync);

        throw_if($response->clientError(), new SynchronizationException($response->json('message')));

        return $response->json();
    }

    /**
     * @param int $importId
     * @param array
     * @return array
     * @throws SynchronizationException
     */
    public function reSync(int $importId, array $dataToSync): array
    {
        $response = $this->syncService->update($importId, $dataToSync);

        throw_if($response->clientError(), new SynchronizationException($response->json('message')));

        return $response->json();
    }

    /**
     * @param int $importId
     * @return mixed
     * @throws SynchronizationException
     */
    public function deSync(int $importId)
    {
        $response = $this->syncService->delete($importId);

        throw_if($response->clientError(), new SynchronizationException($response->json('message')));

        return $response->json();
    }
}
