<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\SizesController;
use App\Http\Controllers\UserController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::apiResource('products', ProductsController::class);
    Route::apiResource('sizes', SizesController::class);
    Route::apiResource('category', CategoryController::class);
});
// Route::get('/category', [CategoryController::class, 'index'])->name('category,index');
// Route::post('/category', [CategoryController::class, 'store'])->name('category,store');
// Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category,show');
// Route::put('/category/{id}', [CategoryController::class, 'update'])->name('category,update');
// Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category,destroy');

// Route::get('/size', [SizesController::class, 'index'])->name('size,index');
// Route::post('/size', [SizesController::class, 'store'])->name('size,store');
// Route::get('/size/{id}', [SizesController::class, 'show'])->name('size,show');
// Route::put('/size/{id}', [SizesController::class, 'update'])->name('size,update');
// Route::delete('/size/{id}', [SizesController::class, 'destroy'])->name('size,destroy');

// Route::get('/product', [ProductsController::class, 'index'])->name('products,index');
// Route::post('/product', [ProductsController::class, 'store'])->name('products,store');
// Route::get('/product/{id}', [ProductsController::class, 'show'])->name('products,show');
// Route::put('/product/{id}', [ProductsController::class, 'update'])->name('products,update');
// Route::delete('/product/{id}', [ProductsController::class, 'destroy'])->name('products,destroy');

Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'regis'])->name('regis');
Route::post('/logout', [UserController::class, 'logout'])->name('user.logout')->middleware(middleware: 'auth:sanctum');
Route::post('/upload', [ProductsController::class, 'uploadFile']);
