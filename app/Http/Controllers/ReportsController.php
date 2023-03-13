<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
 use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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

    public function stock_analysis($id)
    {
        $id == true ? $storeID = $id : $storeID = 0;

        $stores = DB::table('stores')->get(); // remove limit to show all stores
        $selected_store = $this->get_store($stores, $storeID); 
        $storeID = $selected_store->storeID;

        $from = date_sub(now(), date_interval_create_from_date_string("90 days"));
        $to = date_sub(now(), date_interval_create_from_date_string("0 days"));

        $stock_analysis = DB::table('stock_analyses')
                            ->where( [
                                ['date', '>=', $from], ['date', '<=', $to],
                                     ['storeID', '=', $storeID]])
                            ->orderBy('date', 'asc')
                            ->get();
        // return count($stock_analysis);

        $products = DB::table('products')
                        ->where( [['storeID', '=', $storeID]])
                        ->orderBy('onhand', 'DESC')
                        ->get();

        // $nettsales = array_sum( array_column($salesdata->toArray(), 'nettSales') ); 

        return view('portal.store.store_products')
                ->with('stock_analysis', $stock_analysis)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('selected_store', $selected_store)
                ->with('products', $products)
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
