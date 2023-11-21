<?php

//use App\Models\Transactions;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoriesController;
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
Route::get('/transactions/searchNameByMonth/{name}/{selectedMonth}', [TransactionsController::class, 'searchNameByMonth']);
Route::get('/transactions', [TransactionsController::class, 'index']);
Route::post('/transactions', [TransactionsController::class, 'store']);
Route::get('/transactions/searchName/{name}', [TransactionsController::class, 'searchName']);
Route::get('/transactions/searchCategory/{category_name}', [TransactionsController::class, 'searchCategory']);
Route::get('/transactions/searchProperty/{trans_name}', [TransactionsController::class, 'searchProperty']);
Route::get('/transactions/searchByNameAndCategory/{name}/{category_name}', [TransactionsController::class, 'searchByNameAndCategory']);
Route::put('/transactions/{id}', [TransactionsController::class, 'update']);
Route::get('/users', [UserController::class, 'index']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::get('/users/findMoney/{name}', [UserController::class, 'findMoney']);




//Route::resource('products', ProductController::class);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::put('/users/{id}', [UserController::class, 'update']);

});





//Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/categories', [CategoriesController::class, 'index']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
