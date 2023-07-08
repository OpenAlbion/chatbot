<?php

use App\Http\Middleware\BotmanMiddleware;
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

Route::get('/test', function () {
    return view('test');
});

Route::any('/botman', function () {
    $botman = app('botman');
    $botman->middleware->heard(new BotmanMiddleware);
    $botman->listen();
});
