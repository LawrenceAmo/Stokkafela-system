<?php

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\SalesController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

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
    Route::get('products',[ProductController::class, 'get_products'])->name('get_products');

    // Sales
    Route::get('sales',[SalesController::class, 'get_sales'])->name('get_sales');

Route::get('/', [PortalController::class, 'index'])->name('portal');

// });


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
