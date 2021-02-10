<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

use App\Http\Controllers\USerController;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->get('/pizzabuilder', function () {
    return Inertia::render('Container');
})->name('PizzaBuilder');

Route::middleware(['auth:sanctum', 'verified'])->get('/ordersHistory', function () {
    return Inertia::render('OrderHistory');
})->name('OrderHistory');

Route::middleware('auth:sanctum')->get('/pizzabuilder/elements', [UserController::class,'elements']);
Route::middleware('auth:sanctum')->get('/orders', [UserController::class,'orders']);

Route::middleware('auth:sanctum')->post('/pizzabuilder/sendOrder', [UserController::class, 'newOrder']);