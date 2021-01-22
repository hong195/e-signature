<?php

namespace App\Http\Controllers;

use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
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

    public function store(UserStoreRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $user = $user->create($request->validated());

        $user->contacts()->createMany([
            ['name' => 'personal_email', 'value' => $validatedData['contacts']['personal_email']],
            ['name' => 'phone', 'value' => $validatedData['contacts']['phone']],
        ]);

        UserCreated::dispatch($user, $validatedData);

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

    public function update(UserUpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $user->update($request->validated());

        $user->contacts()->delete();

        $user->contacts()->createMany([
            ['name' => 'personal_email', 'value' => $validatedData['contacts']['personal_email']],
            ['name' => 'phone', 'value' => $validatedData['contacts']['phone']],
        ]);

        if ($user->import_id) {
            $password = array_key_exists('password', $validatedData) ? $validatedData['password'] : '';
            UserUpdated::dispatch($user, $password);
        }

        return response()->json(['message' => 'Пользователь успешно обновлен']);
    }

    public function destroy($id): \Illuminate\Http\JsonResponse
    {
        User::destroy($id);

        return response()->json(['message' => 'Пользователь удален']);
    }
}
