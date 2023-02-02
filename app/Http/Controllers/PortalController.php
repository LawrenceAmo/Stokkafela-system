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
            $from = date_sub(now(),date_interval_create_from_date_string("31 days")); 
            $from = date_format($from, 'Y-m-d');

            $to = date_sub(now(),date_interval_create_from_date_string("1 days"));
            $to = date_format($to, 'Y-m-d');
        }else{
            $from = $request->from;
            $to = $request->to;
        }
            $stores = DB::table('stores')->get(); // remove limit to show all stores
            $selected_store = $this->get_store($stores, $request->store || 0); 
            $storeID = $selected_store->storeID;

            $salesdata = DB::table('sales')
                ->where( [['from', '>=', $from], ['to', '<=', $to],
                          ['storeID', '=', $selected_store->storeID]])
                ->orderBy('from', 'asc')
                ->get();

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

