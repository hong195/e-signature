<?php

namespace App\Observers;

use App\Models\Department;
use App\Models\Traits\CompanyToken;
use App\Services\ApiRequest\ApiRequestInterface;
use App\Services\Yandex\YandexService;

class DepartmentObserver
{
    use CompanyToken;

    /**
     * @var ApiRequestInterface
     */
    private $request;

    /**
     * @var ApiRequestInterface
     */
    private $endPoint;

    public function __construct(ApiRequestInterface $request)
    {
        $this->request = $request;
        $this->endPoint = config('yandex_api_endpoint') . '/departments';
    }

    public function saved(Department $department)
    {
        if (!$department->import_id) {
            return;
        }

        $token = $this->getCompanyToken($department->company_id);

        if (!$token) {
            return;
        }
        $syncService = new YandexService($this->request, $this->endPoint, $token);

        $data = ['name' => $department->name];

        if ($department->wasRecentlyCreated) {
            $syncService->store($data);
            return;
        }

        $syncService->update($data);
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

        $syncService = new YandexService($this->request, $this->endPoint, $token);

        $syncService->delete($department->import_id);
    }
}
