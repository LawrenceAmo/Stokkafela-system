<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function PHPUnit\Framework\isEmpty;
use App\Models\Maintanance;

class PortalController extends Controller
{ 
    public function index(Request $request)
    {  
        return redirect('/portal/analysis/stock/0');

        // Check user filter, if not set, set filter request values to default
        if($request>isEmpty() || !$request->from || !$request->to ){
            $from = date_sub(now(), date_interval_create_from_date_string("31 days"));   // get last 30 days date
            $from = date_format($from, 'Y-m-d');

            $to = date_sub(now(), date_interval_create_from_date_string("1 days"));      // Go 1 day back, 
            $to = date_format($to, 'Y-m-d');
         }else{
            // get values from request
            $from = $request->from;
            $to = $request->to;
         }  

        $stores = DB::table('stores')->get();

        $products_data = DB::table('stores')
                        ->join('products', 'stores.storeID', '=', 'products.storeID')
                        ->orderBy('stores.storeID')                          
                        ->get(); 

        $sales_data = DB::table('sales')
                    ->where( [['from', '>=', $from], ['to', '<=', $to], ['daily_total', '=', true]])
                     ->get();
 
        // return view('dashboard')
        //         ->with('products_data', $products_data)
        //         ->with('dates', [ 'from' => $from, 'to' => $to])
        //         ->with('sales_data', $sales_data)
        //         ->with('stores', $stores);
                // ->with('get_products_stats', $this->get_products_stats());
    }
}

    // neo thepii
                    
                    // 0845009738 Eulenda


///////////////////////////////////////////////////////////////////////////////
 