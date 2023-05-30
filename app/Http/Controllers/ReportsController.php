<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;use App\Models\Maintanance;

class ReportsController extends Controller
{
  
    public function get_stock_analysis($id)
    {
        $id == true ? $storeID = $id : $storeID = 0;

        $stores = DB::table('stores')->get(); // remove limit to show all stores
        $selected_store = $this->get_store($stores, $storeID); 
        $storeID = $selected_store->storeID;

        $analysis = new Maintanance();

        return $analysis->stock_analysis($storeID);
    }

    public function stock_analysis($id)
    {
        $id == true ? $storeID = $id : $storeID = 0;

        $stores = DB::table('stores')->get(); // remove limit to show all stores
        $selected_store = $this->get_store($stores, $storeID); 
        $storeID = $selected_store->storeID;
  
        // Test
        $analysis = new Maintanance();
        // return $analysis->stock_analysis($storeID);

        return view('portal.store.store_products')
                // ->with('products', $products)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('selected_store', $selected_store)
                  ;
    }

    public function stock_mabebeza($id, $date = null)
    {
        $id = 18; 
        $id == true ? $storeID = $id : $storeID = 0;

        $stores = DB::table('stores')->get(); // remove limit to show all stores
        $selected_store = $this->get_store($stores, $storeID); 
        $storeID = $selected_store->storeID;
 
        if ($date) {
            $date = date("Y-m", strtotime($date)); //strtotime("first day of -5 months"));
        } else {
            $date = date("Y-m", strtotime("first day of 0 months")); 
        } 

        $stock_analysis = DB::table('stock_analyses')
                            ->join('products', 'products.barcode', '=', 'stock_analyses.code')
                            ->where( [
                                ['stock_analyses.date', 'like', $date."%"],
                                ['products.storeID', '=', $storeID]])
                            ->orderBy('date', 'asc')
                            ->get(); 

        return view('portal.store.stock_analysis')
                ->with('stock_analysis', $stock_analysis)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('date', $date)
                ->with('selected_store', $selected_store);
     } 
}
