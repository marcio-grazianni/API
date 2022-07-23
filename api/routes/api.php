<?php

use App\Http\Controllers\AccessTokenController;
use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResource('columns', ColumnController::class);
Route::apiResource('cards', CardController::class);
Route::get('tokens',[AccessTokenController::class,'index']);
Route::post('cards/update/bulk', [CardController::class, 'bulkUpdate']);
Route::get('list-cards',[CardController::class,'index']);
Route::get('export', function () {
    \Spatie\DbDumper\Databases\MySql::create()
        ->setDbName(env('DB_DATABASE'))
        ->setUserName(env('DB_USERNAME'))
        ->setPassword(env('DB_PASSWORD'))
        ->dumpToFile('backup.sql');

    $path = public_path('backup.sql');
    return response()->download($path);
});
