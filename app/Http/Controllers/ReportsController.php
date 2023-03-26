<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;use App\Models\Maintanance;

class ReportsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
