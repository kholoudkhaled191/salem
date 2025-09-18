<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\OfferProductController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SpecialRequestController;
use App\Http\Controllers\UserController;

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

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// موارد المنتجات والعروض والفروع والمخازن
Route::resource('products', ProductController::class); 
Route::resource('offer_products', OfferProductController::class);
Route::resource('offers', OffersController::class); 
Route::resource('branches', BranchController::class); 
Route::resource('warehouses', WarehouseController::class);
Route::resource('stocks', StockController::class);
Route::resource('transactions', TransactionController::class);

// إدارة الأدمنز
Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
Route::get('/admins/create', [AdminController::class, 'create'])->name('admins.create');
Route::post('/admins', [AdminController::class, 'store'])->name('admins.store');
Route::get('/admins/{id}/edit', [AdminController::class, 'edit'])->name('admins.edit');
Route::put('/admins/{id}', [AdminController::class, 'update'])->name('admins.update');
Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('admins.destroy');

// تسجيل الدخول والخروج
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// الداشبورد لكل الroles
Route::middleware(['auth', 'checkRole:general,branch,warehouse'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});





Route::resource('special-requests', SpecialRequestController::class);




Route::post('/users/store', [UserController::class, 'store'])->name('users.store');

// Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');




