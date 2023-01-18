<?php

use App\Http\Controllers\CreateTodoListItemController;
use App\Http\Controllers\DeleteTodoListItemController;
use App\Http\Controllers\RetrieveTodoListController;
use App\Http\Controllers\RetrieveTodoListItemController;
use App\Http\Controllers\UpdateTodoListItemController;
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

Route::prefix('todolist')->group(function () {
    Route::get('/', RetrieveTodoListController::class);
    Route::get('/{id}', RetrieveTodoListItemController::class);
    Route::post('/', CreateTodoListItemController::class);
    Route::put('/{id}', UpdateTodoListItemController::class);
    Route::delete('/{id}', DeleteTodoListItemController::class);

});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

