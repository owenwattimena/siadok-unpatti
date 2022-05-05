<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\WorkplaceController;

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
Route::group(['prefix' => 'v1'], function () {
    Route::get('select2workplace', [WorkplaceController::class, 'getSelect2Workplace']);
    Route::get('workplace', [WorkplaceController::class, 'getWorkplace'])->name('api-workplace');
    Route::get('alumni', [AlumniController::class, 'getAlumni'])->name('api-alumni');
    Route::post('alumni/image', [AlumniController::class, 'changePhotoProfile']);
});
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
