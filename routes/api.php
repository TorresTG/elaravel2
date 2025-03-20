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
Route::middleware(['auth:sanctum', 'checkadmin',])->group(function () {
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

    //////////////////////////////////////////////////////////////////////////////
// Product Lines
    Route::get('/v1/lineas-de-productos', [LibroController::class, 'indexProductLines']);
    Route::post('/v1/lineas-de-productos', [LibroController::class, 'storeProductLines'])->middleware('checkrole');
    Route::get('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'showProductLines']);
    Route::put('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'updateProductLines'])->middleware('checkrole');
    Route::delete('/v1/lineas-de-productos/{lineaDeProducto}', [LibroController::class, 'destroyProductLines'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Products
    Route::get('/v1/productos', [LibroController::class, 'indexProducts']);
    Route::post('/v1/productos', [LibroController::class, 'storeProducts'])->middleware('checkrole');
    Route::get('/v1/productos/{producto}', [LibroController::class, 'showProducts']);
    Route::put('/v1/productos/{producto}', [LibroController::class, 'updateProducts'])->middleware('checkrole');
    Route::delete('/v1/productos/{producto}', [LibroController::class, 'destroyProducts'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Employees
    Route::get('/v1/empleados', [LibroController::class, 'indexEmployees']);
    Route::post('/v1/empleados', [LibroController::class, 'storeEmployees'])->middleware('checkrole');
    Route::get('/v1/empleados/{empleado}', [LibroController::class, 'showEmployees']);
    Route::put('/v1/empleados/{empleado}', [LibroController::class, 'updateEmployees'])->middleware('checkrole');
    Route::delete('/v1/empleados/{empleado}', [LibroController::class, 'destroyEmployees'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Offices
    Route::get('/v1/oficinas', [LibroController::class, 'indexOffices']);
    Route::post('/v1/oficinas', [LibroController::class, 'storeOffices'])->middleware('checkrole');
    Route::get('/v1/oficinas/{oficina}', [LibroController::class, 'showOffices']);
    Route::put('/v1/oficinas/{oficina}', [LibroController::class, 'updateOffices'])->middleware('checkrole');
    Route::delete('/v1/oficinas/{oficina}', [LibroController::class, 'destroyOffices'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Customers
    Route::get('/v1/clientes', [LibroController::class, 'indexCustomers']);
    Route::post('/v1/clientes', [LibroController::class, 'storeCustomers'])->middleware('checkrole');
    Route::get('/v1/clientes/{cliente}', [LibroController::class, 'showCustomers']);
    Route::put('/v1/clientes/{cliente}', [LibroController::class, 'updateCustomers'])->middleware('checkrole');
    Route::delete('/v1/clientes/{cliente}', [LibroController::class, 'destroyCustomers'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Orders
    Route::get('/v1/pedidos', [LibroController::class, 'indexOrders']);
    Route::post('/v1/pedidos', [LibroController::class, 'storeOrders'])->middleware('checkrole');
    Route::get('/v1/pedidos/{pedido}', [LibroController::class, 'showOrders']);
    Route::put('/v1/pedidos/{pedido}', [LibroController::class, 'updateOrders'])->middleware('checkrole');
    Route::delete('/v1/pedidos/{pedido}', [LibroController::class, 'destroyOrders'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Order Details
    Route::get('/v1/detalles-de-pedidos', [LibroController::class, 'indexOrderDetails']);
    Route::post('/v1/detalles-de-pedidos', [LibroController::class, 'storeOrderDetails'])->middleware('checkrole');
    Route::get('/v1/detalles-de-pedidos/{orderDetailsNumber}', [LibroController::class, 'showOrderDetails']);
    Route::put('/v1/detalles-de-pedidos/{orderDetailsNumber}', [LibroController::class, 'updateOrderDetails'])->middleware('checkrole');
    Route::delete('/v1/detalles-de-pedidos/{orderDetailsNumber}', [LibroController::class, 'destroyOrderDetails'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////

    //////////////////////////////////////////////////////////////////////////////
// Payments
    Route::get('/v1/pagos', [LibroController::class, 'indexPayments']);
    Route::post('/v1/pagos', [LibroController::class, 'storePayments'])->middleware('checkrole');
    Route::get('/v1/pagos/{paymentNumber}', [LibroController::class, 'showPayments']);
    Route::put('/v1/pagos/{paymentNumber}', [LibroController::class, 'updatePayments'])->middleware('checkrole');
    Route::delete('/v1/pagos/{paymentNumber}', [LibroController::class, 'destroyPayments'])->middleware('checkrole');
    //////////////////////////////////////////////////////////////////////////////


    Route::get('/v1/tables', [LibroController::class, 'listTables'])->middleware('checkrole');
    Route::get('/v1/model-fields/{model}', [LibroController::class, 'esquema_modelo'])->middleware('checkrole');

});

