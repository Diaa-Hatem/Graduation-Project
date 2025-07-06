<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryScoreController;
use App\Http\Controllers\Api\ChatBotController;
use App\Http\Controllers\Api\ChildController;
use App\Http\Controllers\Api\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServicePrٍovider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/test', function()
{
    return response('its works',200);
});


Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('child')->controller(ChildController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/create', 'create');
    Route::get('/mychildren/{child_id}', 'mychildern');
    Route::post('/{child_id}/report', 'addReport');
});

Route::prefix('child')->group(function () {
    Route::get('/categories', CategoryController::class);
    Route::get('/questions', QuestionController::class);
    Route::get('/answers', AnswerController::class);

    Route::controller(CategoryScoreController::class)->middleware('auth:sanctum')->group(function () {
        Route::post('/category-score', 'categoryScore');
        Route::get('/mycategory-score/{chili_id}', 'MyCategoryScore');
    });
    Route::post('/chatbot', [ChatBotController::class, 'ask'])->middleware('auth:sanctum');
});







  // Route::post('/update/{child_id}', 'update');
    // Route::delete('/delete/{child_id}', 'delete');
    // Route::delete('/{child_id}/report-delete', 'deleteReport');
