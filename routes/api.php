<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resources([
    'users' => \App\Http\Controllers\UsersController::class,
    'companies' => \App\Http\Controllers\CompaniesController::class,
    'departments' => \App\Http\Controllers\DepartmentsController::class
]);

Route::resource('signature', \App\Http\Controllers\UserSignatureController::Class)->only('store');
