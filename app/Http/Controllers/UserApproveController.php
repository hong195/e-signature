<?php

namespace App\Http\Controllers;

use App\Models\Traits\CompanyToken;
use App\Models\User;
use App\Services\SyncService\Yandex\SyncApiInterface;
use Illuminate\Http\Response;

class UserApproveController extends Controller
{
    use CompanyToken;
    /**
     * @var SyncApiInterface
     */
    private $syncService;

    public function __construct(SyncApiInterface $syncService)
    {
        $this->syncService = $syncService;
    }

    public function update(User $user)
    {
//        if (!$user->wasRecentlyCreated && !$user->import_id) {
//            return response()->json(['message' => 'Отсутсвует Импорт ID'], Response::HTTP_UNPROCESSABLE_ENTITY);
//        }
//
//        $companyId = $user->department->company->id;
//        $token = $this->getCompanyToken($companyId);
//
//        if (!$token) {
//            return response()->json(['message' => 'Токен не найден'], Response::HTTP_UNPROCESSABLE_ENTITY);
//        }
//
//        $this->syncService->setToken($token);
//
//        $data = [
//            'name' => [
//                'first' => $user->name,
//                'last' => $user->surname
//            ],
//            'department_id' => $user->department->import_id,
//            'nickname' => $user->login,
//            'position' => $user->position ?? '',
//            'password' => $user->name . '@' . $user->surname,
//        ];
//
//        $response = $this->syncService->storeResource($data);
//        $body = $response->json();
//
//        if ($response->clientError()) {
//            try {
//                $response->throw();
//            }catch (\Exception $e) {
//                report($e);
//                return response()->json(['message' => $response->body()], $response->status());
//            }
//        }
//
//        $user->password = bcrypt($data['password']);
//        $user->import_id = $body['id'];
//        $user->save();
//
//        return response()->json(['message' => $response->body()], $response->status());
    }
}
