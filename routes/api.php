<?php

use App\Http\Controllers\Api\AnswerController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CategoryScoreController;
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
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// 
Route::controller(AuthController::class)->group(function () {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('logout', 'logout')->middleware('auth:sanctum');
});

Route::prefix('child')->controller(ChildController::class)->middleware('auth:sanctum')->group(function () {
    Route::post('/create', 'create');
    Route::post('/update/{child_id}', 'update');
    Route::delete('/delete/{child_id}', 'delete');
    Route::get('/mychildren', 'mychildern');

    Route::post('/{child_id}/report', 'addReport');
    Route::delete('/{child_id}/report-delete', 'deleteReport');

    Route::post('/{child_id}/total-questions-score', 'addTotalScore');
});

Route::prefix('child')->group(function () {
    Route::get('/categories', CategoryController::class);
    Route::get('/questions', QuestionController::class);
    Route::get('/answers', AnswerController::class);

    Route::post(
        '/{child_id}/category-score/{category_id}',
        [CategoryScoreController::class, 'categoryScore']
    )->middleware('auth:sanctum');
});
