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
Route::get('/transactions/searchNameByMonth/{name}/{selectedMonth}', [TransactionsController::class, 'searchNameByMonth']); //havi kimutatás
Route::get('/transactions', [TransactionsController::class, 'index']); //tranzakció listázás
Route::post('/transactions', [TransactionsController::class, 'store']); // tranzakció létrehozás
Route::get('/transactions/searchName/{name}', [TransactionsController::class, 'searchName']); //tranzakció listázás név alapján
Route::get('/transactions/searchCategory/{category_name}', [TransactionsController::class, 'searchCategory']); //tranzakció listázása kategória alapján
Route::get('/transactions/searchProperty/{trans_name}', [TransactionsController::class, 'searchProperty']); //vagyontárgyak listázása
Route::get('/transactions/sumByNameAndCategory/{name}/{category_name}', [TransactionsController::class, 'sumByNameAndCategory']); //adott kategória price összege
Route::get('/transactions/lastOneOfCategory/{name}/{category_name}', [TransactionsController::class, 'lastOneOfCategory']); //adott kategória utolsó tranzakciója
Route::get('/transactions/searchByNameAndCategory/{name}/{category_name}', [TransactionsController::class, 'searchByNameAndCategory']); //kategóriánkénti szűrés
Route::get('/transactions/listIsincome/{name}/{is_income}', [TransactionsController::class, 'listIsincome']); //bevétel lekérdezése
Route::put('/transactions/{id}', [TransactionsController::class, 'update']); //tranzakció módosítás
Route::get('/users', [UserController::class, 'index']); //felhasználók listázása
Route::get('/users/{id}', [UserController::class, 'show']); //felhasználó megjelenítése
Route::get('/users/findMoney/{name}', [UserController::class, 'findMoney']); //egyenleg lekérdezése money-kiadás+bevétel
Route::get('/categories', [CategoriesController::class, 'index']); //kategóriák listázása
Route::post('/register', [AuthController::class, 'register']); //regisztráció
Route::post('/login', [AuthController::class, 'login']); //bejelentkezés
Route::put('/users/{id}', [UserController::class, 'update']);


//Route::resource('products', ProductController::class);

//Protected routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::post('/logout', [AuthController::class, 'logout']);


});





//Public routes
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
