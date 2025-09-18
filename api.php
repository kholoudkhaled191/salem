<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OffersController;
use App\Http\Controllers\SpecialRequestController;
use App\Http\Controllers\DashboardController;

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

Route::middleware(['auth:sanctum', 'api.error'])->get('/user', function (Request $request) {
    return $request->user();
});

// API Routes with error handling
Route::middleware('api.error')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('offers', OffersController::class);
});

// Health check endpoint
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now(),
        'version' => '1.0.0'
    ]);
});




// Route::get('/products', [ProductController::class, 'index']);   // كل المنتجات
// Route::get('/products/{id}', [ProductController::class, 'show']); // منتج واحد



// Route::get('/products/{id}/offers', [ProductController::class, 'showWithOffers']);

Route::get('/products', [ProductController::class, 'getAllProducts']);


Route::get('/products-with-offers', [ProductController::class, 'getProductsWithOffers']);




Route::post('/special-request', [SpecialRequestController::class, 'store']);



// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');