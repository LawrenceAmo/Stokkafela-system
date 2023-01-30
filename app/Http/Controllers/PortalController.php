<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class PortalController extends Controller
{
    public function index(Request $request)
    {   
 
        if($request>isEmpty() || !$request->from || !$request->to || !$request->store){
            $from = date_sub(now(),date_interval_create_from_date_string("14 days")); 
            $from =  date_format($from, 'Y-m-d');

            $to = date_sub(now(),date_interval_create_from_date_string("1 days"));
            $to = date_format($to, 'Y-m-d');

            $store = DB::table('stores')->limit(1)->get(['storeID', 'name']); // remove limit to show all stores
        }else{
            $store = DB::table('stores')->where('storeID',$request->store)->get(['storeID', 'name']);
            $from = $request->from;
            $to = $request->to;
        }
        $storeID = $store[0]->storeID; 

        $salesdata = DB::table('sales')
                // ->leftJoin('products','products.barcode','=','sales.barcode')
                ->where([['from', '>=', $from], ['to', '<=', $to], ['storeID', '=', $store[0]->storeID]])
                ->orderBy('from', 'asc')
                ->get();
        
        $sales = array_sum( array_column($salesdata->toArray(), 'sales') );
        $nettsales = array_sum( array_column($salesdata->toArray(), 'nettSales') );

        return view('dashboard')
                ->with('salesdata', $salesdata)
                ->with('dates', [ 'from' => $from, 'to' => $to])
                ->with('sales', $sales)
                ->with('storeID', $storeID)
                ->with('stores', $store)
                ->with('nettsales', $nettsales)
                ->with('get_products_stats', $this->get_products_stats());
    }
}


// SELECT SUM(sales) from `sales` WHERE `from` like '2023-01-18%';