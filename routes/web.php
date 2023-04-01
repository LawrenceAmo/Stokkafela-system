<?php

use App\Models\Test;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\UsersController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\SalesController; 
use App\Http\Controllers\RepsController; 
use App\Http\Controllers\MaintananceController;
use App\Http\Controllers\TargetsController;
use Illuminate\Support\Facades\DB; 

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
        function convert($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }
    echo convert(memory_get_usage(true)); // 123 kb
 */

Route::get('/', function () {
    
    // return view('dashboard', ['num'=>128]);
    return redirect()->to('portal/');
});

Route::prefix('portal/' )->middleware(['auth'])->group(function ()
{

    Route::get('/', [PortalController::class, 'index'])->name('portal');

// Maintance
Route::get('/maintanance', [MaintananceController::class, 'index'])->name('maintanance');
Route::post('/maintanance/stock-analysis/save', [MaintananceController::class, 'stock_analysis'])->name('save_stock_analysis');

//  profile
Route::get('/profile', [UsersController::class, 'index'])->name('profile');
Route::post('/profile/update', [UsersController::class, 'update'])->name('update_profile');
Route::post('/profile/delete', [UsersController::class, 'create'])->name('delete_profile');

// Staff members
Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::get('/staff/create', [StaffController::class, 'create'])->name('create_staff');
Route::get('/staff/save', [StaffController::class, 'index'])->name('save_staff');
Route::get('/staff/edit/{id}', [StaffController::class, 'index'])->name('edit_staff');
Route::get('/staff/delete/{id}', [StaffController::class, 'index'])->name('delete_staff');


//  departments
Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments');
Route::post('/departments/create', [DepartmentsController::class, 'create'])->name('create_department');
Route::get('/departments/delete/{id}', [DepartmentsController::class, 'delete'])->name('delete_department');
Route::get('/departments/edit/{id}', [DepartmentsController::class, 'edit'])->name('edit_department');
Route::post('/departments/save', [DepartmentsController::class, 'save'])->name('save_department');


// Store
Route::get('/stores', [StoreController::class, 'index'])->name('stores');
Route::get('/store/{id?}', [StoreController::class, 'show'])->name('store');
Route::get('/store/create', [StoreController::class, 'create'])->name('create_store');
Route::post('/store/save', [StoreController::class, 'save'])->name('save_store');
Route::get('/store/edit/{id}', [StoreController::class, 'edit'])->name('edit_store');
Route::post('/store/update', [StoreController::class, 'update'])->name('update_store');
Route::get('/store/delete/{id}', [StoreController::class, 'destroy'])->name('delete_store');

//  Products
Route::get('/products', [ProductController::class, 'index'])->name('products');
Route::get('/product/create', [ProductController::class, 'create'])->name('create_product');
Route::POST('/product/save', [ProductController::class, 'save'])->name('save_product');
// Route::get('/product', [StoreController::class, 'index'])->name('save_store');

// Stock Analysis / Reports
Route::get('/analysis/stock/{id}', [ReportsController::class, 'stock_analysis'])->name('stock_analysis');

//  Sales
Route::get('/sales', [SalesController::class, 'index'])->name('sales');
Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::post('/sales/create/repsale', [SalesController::class, 'create_rep_sale'])->name('create_rep_sale');
Route::POST('/sales/save', [SalesController::class, 'save'])->name('save_sales');
Route::get('/sales/analysis', [SalesController::class, 'sales_analysis'])->name('sales_analysis');
Route::get('/sales/repsale/update/{id}/{delete?}', [SalesController::class, 'update_rep_sale'])->name('update_rep_sale');
Route::post('/sales/repsale/save', [SalesController::class, 'save_rep_sale'])->name('save_rep_sale');
Route::get('/sales/repsale/delete/{id}', [SalesController::class, 'delete_rep_sale'])->name('delete_rep_sale');

 
//  Debtors
Route::get('/debtors', [RepsController::class, 'index'])->name('debtors');
// Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::POST('/debtors/rep/create', [RepsController::class, 'create_rep'])->name('create_rep');
Route::get('/debtors/rep/update/{id}/{delete?}', [RepsController::class, 'update_rep'])->name('update_rep');
Route::post('/debtors/rep/save', [RepsController::class, 'save_rep'])->name('save_rep');
Route::get('/debtors/rep/delete/{id}', [RepsController::class, 'delete_rep'])->name('delete_rep');

// 

//  Targets
// Route::get('/targets', [RepsController::class, 'index'])->name('debtors');
// Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::POST('/targets/rep/create', [TargetsController::class, 'create_rep_target'])->name('create_rep_target');
// Route::get('/sales/analysis', [SalesController::class, 'sales_analysis'])->name('sales_analysis');



//  Job Roles and Titles
// Route::get('/jobs', [ProductController::class, 'index'])->name('my_products');
// Route::get('/product/create', [ProductController::class, 'create'])->name('create_product');
// .Route::POST('/product/save', [ProductController::class, 'save'])->name('save_product');
// Route::get('/product', [StoreController::class, 'index'])->name('save_store');

});
 
 
require __DIR__.'/auth.php';    // Routes for Auth





