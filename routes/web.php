<?php

use App\Http\Controllers\API\URLController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('crawler.request');
});

Route::prefix('v1')->group(function () {
    Route::post('url-crawler', [URLController::class, 'crawler'])->name("url-request.crawler");
    Route::get('url-crawler/history', [URLController::class, 'history'])->name("url-request.history");
    Route::get('url-crawler/{id}', [URLController::class, 'detail'])->name("url-request.detail");
    Route::get('url-crawler/{id}/xml', [URLController::class, 'xml'])->name("url-request.xml");
});