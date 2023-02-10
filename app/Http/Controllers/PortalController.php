<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;

class PortalController extends Controller
{
    public function index(Request $request)
    {  
        // Check user filter, if not set, set filter request values to default
        if($request>isEmpty() || !$request->from || !$request->to || !$request->store){
            $from = date_sub(now(), date_interval_create_from_date_string("31 days"));   // get last 30 days date
            $from = date_format($from, 'Y-m-d');

            $to = date_sub(now(), date_interval_create_from_date_string("1 days"));      // Go 1 day back, 
            $to = date_format($to, 'Y-m-d');
            $storeID = 0;
        }else{
            // get values from request
            $from = $request->from;
            $to = $request->to;
            $storeID = $request->store;
        }
            $stores = DB::table('stores')->get(); // remove limit to show all stores
            $selected_store = $this->get_store($stores, $storeID); 
            $storeID = $selected_store->storeID;

            $salesdata = DB::table('stores')
                            ->join('products', 'stores.storeID', '=', 'products.storeID')
                            ->join('sales', 'stores.storeID', '=', 'sales.storeID')
            // ->where( [['from', '>=', $from], ['to', '<=', $to],
                                    // ['storeID', '=', $storeID]
                                    // ])
                            //  ->orderBy('from', 'asc')
                            ->limit(10000)
                            ->get();

            // return $salesdata;
 
            $sales = array_sum( array_column($salesdata->toArray(), 'sales') );
            $nettsales = array_sum( array_column($salesdata->toArray(), 'nettSales') );

        return view('dashboard')
                ->with('salesdata', $salesdata)
                ->with('dates', [ 'from' => $from, 'to' => $to])
                ->with('sales', $sales)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('selected_store', $selected_store)
                ->with('nettsales', $nettsales)
                ->with('get_products_stats', $this->get_products_stats());
    }
}

