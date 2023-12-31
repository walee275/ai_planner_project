<?php

use App\Http\Controllers\PlanController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('save-plan/tasks', [PlanController::class, 'create_tasks'])->name('create_tasks');
Route::post('save-plan', [PlanController::class, 'create_plan'])->name('create_plan');
Route::post('request-plan', [PlanController::class, 'request_gpt'])->name('request_gpt');
