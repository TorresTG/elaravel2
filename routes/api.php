<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TokenController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\Juego;

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

// hello
Route::get('/hello', function () {
    return 'hello';
});

// rutas que solo puedes acceder si eres admin }
Route::middleware([ 'auth:sanctum','checkadmin',])->group(function () {
    Route::get('/v1/isAdmin', [AdminController::class, 'isAdmin']);
    Route::get('/v1/users', [AdminController::class, 'getUsers']);
    Route::post('/v1/activate', [AdminController::class, 'activateUser']);
    Route::get('/v1/admin', [AdminController::class, 'index']);
    Route::put('/v1/admin', [AdminController::class, 'update']);
    Route::post('/v1/baja', [AdminController::class, 'baja']);

    Route::get('/v1/gamesview', [juego::class, 'listGames']);
    Route::get('/v1/gamesview/{id}', [juego::class, 'showGame'])
        ->where('id', '[0-9]+');
});

Route::get('/activate/{user}', [AuthController::class, 'activateAccount'])->name('user.activate')->middleware('signed');
Route::post('/v1/renviar', [AuthController::class, 'resendActivationLink'])->name('activation-link')->middleware('checkinactive');

Route::post('/v1/register', [AuthController::class, 'register_sanctum'])->name('register');
Route::post('/v1/login', [AuthController::class, 'login_sanctum'])->name('login')->middleware(['checkinactive']);
Route::get('/v1/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/v1/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::post('/v1/picture', [ImageController::class, 'subirImagen'])->middleware('auth:sanctum');
Route::get('/v1/picture', [ImageController::class, 'obtenerImagen'])->middleware('auth:sanctum');
//con s3
Route::post('/v1/picture-s3', [ImageController::class, 'uploadProfilePicture'])->middleware('auth:sanctum');
Route::get('/v1/picture-s3', [ImageController::class, 'getProfilePicture'])->middleware('auth:sanctum');


// esto no
Route::post('/token-command', [TokenController::class, 'store']);
Route::get('/token-command', [TokenController::class, 'show']);

//tokmail
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/index', [EmailController::class, 'index']);
    Route::get('/email-command', [EmailController::class, 'sendEmail']);
    Route::post('/email', [EmailController::class, 'archivo']);
});
//juego
/*
Route::middleware(['auth:sanctum','checkrole', 'checkactive', 'checkinactive'])->group(function () {
    Route::get('/user', [AuthController::class, 'me']);

    Route::post('/v1/game', [Juego::class, 'game']);
    Route::post('/v1/join/{id}', [Juego::class, 'join'])
        ->where('id', '[0-9]+');
    Route::post('/v1/barcos/{id}', [Juego::class, 'barcos'])
        ->where('id', '[0-9]+');
    Route::post('/v1/atacar/{id}', [Juego::class, 'atacar'])
        ->where('id', '[0-9]+');
    Route::post('/v1/abandonar/{id}', [Juego::class, 'abandonar'])
        ->where('id', '[0-9]+');
    Route::post('/v1/consultaratakes/{id}', [Juego::class, 'consultaratakes'])
        ->where('id', '[0-9]+');
    Route::post('/v1/consultar/{id}', [Juego::class, 'consultar'])
        ->where('id', '[0-9]+');
    Route::post('/v1/partidosjuego', [Juego::class, 'partidosjuego']);
});
*/
//Tablas
Route::middleware(['auth:sanctum'])->group(function () {
    //////////////////////////////////////////////////////////////////////////////
    // Mostrar todos lal librerías
    Route::get('/v1/librerías', [LibroController::class, 'indexLibrerías']);
    // Crear
    Route::post('/v1/librerías', [LibroController::class, 'storeLibrerías'])->middleware('checkrole');
    // Uno en especifico
    Route::get('/v1/librerías/{librería}', [LibroController::class, 'showLibrerías']);
    // Actualizar
    Route::put('/v1/librerías/{librería}', [LibroController::class, 'updateLibrerías'])->middleware('checkrole');
    // Eliminar
    Route::delete('/v1/librerías/{librería}', [LibroController::class, 'destroyLibrerías'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

});
