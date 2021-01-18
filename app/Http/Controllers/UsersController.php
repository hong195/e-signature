<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(Request $request): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $perPage = $request->get('perPage', 15);
        $page = $request->get('page', 1);

        $users =  User::query()
            ->when($request->get('qs'), function ($query, $qs) {
                $query->where('name', 'like', "$qs")
                    ->orWhere('surname', 'like', "$qs");
            })
            ->when($request->get('department_id'), function ($query, $department_id) {
                $query->where('department_id', $department_id);
            })
            ->when($request->get('has_signature'), function ($query, $department_id) {
                $query->where('department_id', $department_id);
            })
            ->paginate($perPage, $columns = ['*'], $pageName = 'page', $page);

        return UserResource::collection($users);
    }

    public function create()
    {

    }

    public function store(UserRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $user->create($request->validated());
        return response()->json(['message' => 'Ваша заявка принята']);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function edit($id)
    {
        //
    }

    public function update(UserRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $user->update($request->validated());
        return response()->json(['message' => 'Пользователь успешно обновлен']);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        User::destroy($id);

        return response()->json(['message' => 'Пользователь удален']);
    }
}
