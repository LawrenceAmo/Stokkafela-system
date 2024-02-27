<?php

use App\Http\Controllers\Admin\AdminController;
use App\Models\Test;
use Illuminate\Support\Facades\Route;
 use App\Http\Controllers\UsersController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\Admin\DepartmentsController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\DestributorsController;
use App\Http\Controllers\DocumentsController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\LeaveTypeController;
use App\Http\Controllers\SalesController; 
use App\Http\Controllers\RepsController; 
use App\Http\Controllers\MaintananceController;
use App\Http\Controllers\PositionController;
use App\Http\Controllers\RoleController; 
use App\Http\Controllers\ShoppingController;
use App\Http\Controllers\SpazaShopsController;
use App\Http\Controllers\TargetsController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\StoreLocationsController;
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
    return view('welcome');
    // return redirect()->to('portal/');
});

Route::prefix('portal/' )->middleware(['auth'])->group(function ()
{
    Route::get('/test', function () {          
        return view('portal.test');
     });
     Route::get('/tests', [AdminController::class, 'test']);


    Route::get('/', [PortalController::class, 'index'])->name('portal');

// Maintance 
Route::get('/maintanance', [MaintananceController::class, 'index'])->name('maintanance');
Route::post('/maintanance/stock-analysis/save', [MaintananceController::class, 'stock_analysis'])->name('save_stock_analysis');
Route::post('/maintanance/delete_rep_sale_by_date', [MaintananceController::class, 'delete_rep_sale_by_date'])->name('delete_rep_sale_by_date');
Route::post('/maintanance/product/manufacturers', [MaintananceController::class, 'save_product_manufacturers'])->name('save_product_manufacturers');

//  profile
Route::get('/profile', [UsersController::class, 'index'])->name('profile');
Route::post('/profile/update', [UsersController::class, 'update'])->name('update_profile');
Route::post('/profile/delete', [UsersController::class, 'create'])->name('delete_profile');

// Staff members
Route::get('/staff', [StaffController::class, 'index'])->name('staff');
Route::get('/staff/create', [StaffController::class, 'create'])->name('create_staff');
Route::post('/staff/save', [StaffController::class, 'save_staff'])->name('save_staff');
Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('edit_staff');
Route::get('/staff/delete/{id}', [StaffController::class, 'delete_staff'])->name('delete_staff');
Route::post('/staff/update/save', [StaffController::class, 'update_staff_profile'])->name('update_staff_profile');

// Staff Shopping
Route::get('/shopping', [ShoppingController::class, 'index'])->name('shopping');
Route::get('/shopping/admin', [ShoppingController::class, 'index_admin'])->name('shopping_admin');
Route::get('/shopping/staff/thank-you', [ShoppingController::class, 'staff_order_thank_you'])->name('staff_order_thank_you');
Route::get('/shopping/cart/create', [ShoppingController::class, 'create_cart'])->name('create_cart');
Route::get('/shopping/order/items/{orderID}', [ShoppingController::class, 'staff_ordered_items'])->name('staff_ordered_items');
Route::get('/shopping/order/items/admin/{orderID}', [ShoppingController::class, 'staff_ordered_items_admin'])->name('staff_ordered_items_admin');
// Route::post('/shopping/cart/save', [ShoppingController::class, 'staff_save_order'])->name('staff_save_order');
// Route::get('/staff/edit/{id}', [StaffController::class, 'edit'])->name('edit_staff');
// Route::get('/staff/delete/{id}', [StaffController::class, 'delete_staff'])->name('delete_staff');
// Route::post('/staff/update/save', [StaffController::class, 'update_staff_profile'])->name('update_staff_profile');

//  departments
Route::get('/departments', [DepartmentsController::class, 'index'])->name('departments');
Route::post('/departments/create', [DepartmentsController::class, 'create'])->name('create_department');
Route::get('/departments/delete/{id}', [DepartmentsController::class, 'delete'])->name('delete_department');
Route::get('/departments/edit/{id}', [DepartmentsController::class, 'edit'])->name('edit_department');
Route::post('/departments/save', [DepartmentsController::class, 'save'])->name('save_department');

// Store Lovations
Route::get('/store/locations', [StoreLocationsController::class, 'index'])->name('store_locations');
Route::get('/store/locations/edit/{id}', [StoreLocationsController::class, 'edit'])->name('store_location_update');
Route::post('/store/location/save', [StoreLocationsController::class, 'save_store_locations'])->name('save_store_locations');
Route::post('/store/location/update', [StoreLocationsController::class, 'update_store_location'])->name('update_store_location');

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
Route::POST('/product/store/delete', [ProductController::class, 'delete_store_product'])->name('delete_store_product');
// Route::get('/product', [StoreController::class, 'index'])->name('save_store');

// Stock Analysis / Reports 
Route::get('/analysis/stock/{id}', [ReportsController::class, 'stock_analysis'])->name('stock_analysis');
Route::get('/analysis/stock/mabebeza/{id}/{date?}', [ReportsController::class, 'stock_mabebeza'])->name('stock_mabebeza');

//  Sales
Route::get('/sales', [SalesController::class, 'index'])->name('sales');
Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::post('/sales/create/repsale', [SalesController::class, 'create_rep_sale'])->name('create_rep_sale');
Route::POST('/sales/save', [SalesController::class, 'save'])->name('save_sales');
Route::get('/sales/analysis/{id?}/', [SalesController::class, 'sales_analysis'])->name('sales_analysis');
Route::get('/sales/repsale/update/{id}/{delete?}', [SalesController::class, 'update_rep_sale'])->name('update_rep_sale');
Route::post('/sales/repsale/save', [SalesController::class, 'save_rep_sale'])->name('save_rep_sale');
Route::post('/sales/repsale/import', [SalesController::class, 'import_rep_sales'])->name('import_rep_sales');
Route::get('/sales/repsale/delete/{id}', [SalesController::class, 'delete_rep_sale'])->name('delete_rep_sale');
 
//  Debtors // destributor
Route::get('/debtors', [RepsController::class, 'index'])->name('debtors');
// Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::POST('/debtors/destributor/create', [DestributorsController::class, 'create_destributor'])->name('create_destributor');
Route::get('/debtors/destributor/update/{id}/{delete?}', [DestributorsController::class, 'update_destributor'])->name('update_destributor');
Route::post('/debtors/destributor/save', [DestributorsController::class, 'save_destributor'])->name('save_destributor');

    // ////// Reps
Route::POST('/debtors/rep/create', [RepsController::class, 'create_rep'])->name('create_rep');
Route::get('/debtors/rep/update/{id}/{delete?}', [RepsController::class, 'update_rep'])->name('update_rep');
Route::post('/debtors/rep/save', [RepsController::class, 'save_rep'])->name('save_rep');
Route::post('/debtors/rep/upload', [RepsController::class, 'upload_rep'])->name('upload_rep');
Route::get('/debtors/rep/delete/{id}', [RepsController::class, 'delete_rep'])->name('delete_rep');
 
//  Targets
// Route::get('/targets', [RepsController::class, 'index'])->name('debtors');
// Route::get('/sales/create', [SalesController::class, 'create'])->name('create_sales');
Route::POST('/targets/rep/create', [TargetsController::class, 'create_rep_target'])->name('create_rep_target');
Route::POST('/targets/rep/createbydes', [TargetsController::class, 'create_rep_target_bydes'])->name('create_rep_target_bydes');
Route::get('/targets/rep/update/{id}', [TargetsController::class, 'update_rep_target'])->name('update_rep_target');
Route::post('/targets/rep/save', [TargetsController::class, 'save_rep_target'])->name('save_rep_target');
// Route::get('/sales/analysis', [SalesController::class, 'sales_analysis'])->name('sales_analysis');

 
//  Job Roles and Titles
Route::post('/roles/create', [RoleController::class, 'create_role'])->name('create_role'); 
Route::post('/roles/delete/{id}', [RoleController::class, 'destroy'])->name('delete_role');
Route::get('/roles/update/{id}', [RoleController::class, 'update_role'])->name('update_role');
Route::post('/roles/save', [RoleController::class, 'save_role'])->name('save_role');


//      Spaza Shops
Route::get('/spaza/shops', [SpazaShopsController::class, 'index'])->name('spaza_shops');
Route::post('/spaza/shops/save', [SpazaShopsController::class, 'save_spaza_shops'])->name('save_spaza_shops');
Route::post('/spaza/shops/upload', [SpazaShopsController::class, 'upload_spaza_shops'])->name('upload_spaza_shops');
Route::post('/spaza/shop/update', [SpazaShopsController::class, 'update_spaza_shop'])->name('update_spaza_shop');
Route::get('/spaza/shop/{id}', [SpazaShopsController::class, 'spaza_shop_view'])->name('spaza_shop_view');
Route::get('/spaza/shops/delete/{id}', [SpazaShopsController::class, 'spaza_shop_delete'])->name('spaza_shop_delete');
// Route::get('/spaza/shops', [SpazaShopsController::class, 'index'])->name('spaza_shops');
 

//    Documents
Route::get('/documents', [DocumentsController::class, 'index'])->name('documents');
Route::get('/documents/delete/{id}', [DocumentsController::class, 'delete_doc'])->name('delete_doc');
Route::post('/documents/create', [DocumentsController::class, 'create'])->name('document_create');


//    Staff Leaves
Route::get('/leave', [LeaveRequestController::class, 'index'])->name('leave');
Route::get('/leave/admin', [LeaveRequestController::class, 'leave_admin'])->name('leave_admin');
Route::get('/leave/admin/balances', [LeaveTypeController::class, 'leave_balances'])->name('leave_balances');
Route::post('/leave/request', [LeaveRequestController::class, 'leave_request'])->name('leave_request');
Route::post('/leave/request/update', [LeaveRequestController::class, 'update_leave_request'])->name('update_leave_request');
Route::post('/leave/type/create', [LeaveTypeController::class, 'create_leave_type'])->name('create_leave_type');
Route::post('/leave/type/staff/balance', [LeaveTypeController::class, 'create_staff_leave_balance'])->name('create_staff_leave_balance');
Route::post('/leave/type/staff/balance/update', [LeaveTypeController::class, 'update_staff_leave_balance'])->name('update_staff_leave_balance');

});
 
Route::get('doh/{id}',[ReportsController::class, 'get_stock_analysis']); ////

Route::get('/mailtest', [TestController::class, 'mailtest'])->name('mailtest');

require __DIR__.'/auth.php';    // Routes for Auth





