<?php

namespace App\Http\Controllers;

use App\Enums\UserStatus;
use App\Events\UserCreated;
use App\Events\UserUpdated;
use App\Forms\UserForm;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Resources\UserResource;
use App\Jobs\GenerateUserSignatureJob;
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

    public function create(UserForm $form)
    {
        return response()->json(['form' => $form->get()]);
    }

    public function store(UserStoreRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $user = $user->create($request->validated());

        UserCreated::dispatch($user, $validatedData);

        return response()->json(['message' => 'Ваша заявка принята']);
    }

    public function show(User $user)
    {
        return UserResource::make($user);
    }

    public function edit(UserForm $form, int $id)
    {
        $attr = User::find($id);

        return response()->json(['form' => $form->fill($attr)->get()]);
    }

    public function update(UserUpdateRequest $request, User $user): \Illuminate\Http\JsonResponse
    {
        $validatedData = $request->validated();

        $user->update($request->validated());

        if ($user->import_id) {
            $password = array_key_exists('password', $validatedData) ? $validatedData['password'] : '';
            UserUpdated::dispatch($user, $password);
        }

        return response()->json(['message' => 'Пользователь успешно обновлен']);
    }

    public function destroy(User $user): \Illuminate\Http\JsonResponse
    {
        $user->status = UserStatus::DISMISSED;

        if ($user->import_id) {
            UserUpdated::dispatch($user);
        }

        return response()->json(['message' => 'Пользователь удален']);
    }
}
