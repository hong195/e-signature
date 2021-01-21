<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Traits\CompanyToken;
use App\Services\SyncService\Interfaces\SynchronizerServiceInterface;

class DepartmentObserver
{
    use CompanyToken;

    private $url;

    public function __construct()
    {
        $this->url = config('yandex.connect.directory_api.endpoint') . '/departments';
    }

    /**
     * @param Department $department
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function saved(Department $department)
    {
        $token = $this->getCompanyToken($department->company_id);

        if (!$token || (!$department->wasRecentlyCreated && !$department->import_id)) {
            return;
        }

        $syncService = app()->make(SynchronizerServiceInterface::class, [ 'url' => $this->url, 'token' => $token]);

        $data = ['name' => $department->name, 'parent_id' => 1];

        try {
            $response = $department->wasRecentlyCreated
                ? $syncService->sync($data)
                : $syncService->reSync($department->import_id,$data);
        }catch (\Exception $e){
            report($e);
            throw $e;
        }

        $department->import_id = $response['id'];
        $department->saveQuietly();
    }

    /**
     * @param Department $department
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     * @throws \Exception
     */
    public function deleted(Department $department)
    {
        $token = $this->getCompanyToken($department->company_id);

        if (!$token || !$department->import_id) {
            return;
        }

        $syncService = app()->make(SynchronizerServiceInterface::class, [ 'url' => $this->url, 'token' => $token]);

        try {
            $syncService->deleteResource($department->import_id);
        }catch (\Exception $e){
            report($e);
            throw $e;
        }
    }
}
