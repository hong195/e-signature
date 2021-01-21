<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Traits\CompanyToken;
use App\Services\SyncService\SyncInterface;

class DepartmentObserver
{
    use CompanyToken;

    private $syncService;

    public function __construct(SyncInterface $syncService)
    {
        $this->syncService = $syncService;
    }

    public function saved(Department $department)
    {
        if (!$department->wasRecentlyCreated && !$department->import_id) {
            return;
        }

        $token = $this->getCompanyToken($department->company_id);

        if (!$token) {
            return;
        }

        $this->syncService->setToken($token);
        $data = ['name' => $department->name, 'parent_id' => 1];

        $response = $department->wasRecentlyCreated
                    ? $this->syncService->storeResource($data)
                    : $this->syncService->updateResource($department->import_id,$data);

        if ($response->clientError()) {
            $response->throw();
        }

        $body = $response->json();
        $department->import_id = $body['id'];
        $department->saveQuietly();
    }

    public function deleted(Department $department)
    {
        if (!$department->import_id) {
            return;
        }

        $token = $this->getCompanyToken($department->company_id);

        if (!$token) {
            return;
        }

        $response = $this->syncService->deleteResource($department->import_id);

        if ($response->clientError()) {
            $response->throw();
        }
    }
}
