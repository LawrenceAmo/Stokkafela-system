<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\MaintananceController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\ShoppingController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\PortalController;
Route::get('/', function () {

     $s = time();
    for($i = 0; $i < 1000; $i++){
         User::find(1);
    } 
       $e= time();
 
    return [(int)$e , (int)$s];
});


// Route::prefix('portal/' )->middleware(['auth'])->group(function ()
// {

    // Products
    Route::get('/mabebeza/products',[ProductController::class, 'get_mabebeza_stock'])->name('get_mabebeza_stock');
    Route::get('products',[ProductController::class, 'get_products'])->name('get_products');
    Route::get('/product/top_products', [ProductController::class, 'get_top_products'])->name('get_top_products');
// 
 
    // Sales
    Route::get('sales',[SalesController::class, 'get_sales'])->name('get_sales');
    Route::get('queue/jobs',[MaintananceController::class, 'get_jobs'])->name('get_jobs');
    Route::get('queue/start',[MaintananceController::class, 'queue_jobs_start'])->name('queue_jobs_start');
    Route::get('get_stock_analysis/{id}',[ReportsController::class, 'get_stock_analysis'])->name('get_stock_analysis');

Route::get('/', [PortalController::class, 'get_all_stores_data'])->name('get_all_stores_data'); // test

// });

// Staff Shopping
Route::post('/shopping/cart/save', [ShoppingController::class, 'staff_save_order'])->name('staff_save_order');



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
