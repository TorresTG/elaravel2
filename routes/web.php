<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
    
});
Route::get('/activate/{user}', [AuthController::class, 'redireccionActivate'])
     ->name('user.activate')
     ->middleware('signed');
Route::post('/digitActivate', [AuthController::class, 'digitAA'])->name('user.digitAA');
//Route::get('/redir', [AuthController::class, 'redireccionActivate'])->name('user.redir');

Route::post('/resend-activation-code', [AuthController::class, 'resendActivationCode'])->name('resend-activation-code');