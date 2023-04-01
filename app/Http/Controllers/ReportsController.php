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
        // return $id;
    }

    public function stock_analysis($id)
    {
        $id == true ? $storeID = $id : $storeID = 0;

        $stores = DB::table('stores')->get(); // remove limit to show all stores
        $selected_store = $this->get_store($stores, $storeID); 
        $storeID = $selected_store->storeID;
  

        return view('portal.store.store_products')
                // ->with('products', $products)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('selected_store', $selected_store)
                  ;
    }

 
}
