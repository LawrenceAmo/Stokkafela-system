<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\CSVImport;
use App\Models\Sales;
use Maatwebsite\Excel\Facades\Excel;
 use Illuminate\Support\Facades\Auth;
 use function PHPUnit\Framework\returnSelf;
use PHPExcel;
class SalesController extends Controller
{
    public function get_sales( )
    {
        $sales = DB::table('sales')->limit(100)->get();
        return $sales->toArray();
    }
  
    public function index()
    {
     
        $stores = DB::table('stores')->get(['storeID','name']); 

        return view('portal.sales.index')
                ->with('stores', $stores)
                ->with('get_products_stats', $this->get_products_stats());

    }

 
    public function create()
    {
        return true;
    }

    public function save(Request $request)
    {
        $request->validate([
                // 'date_from' => 'required',
                // 'date_to' => 'required',
                'store' => 'required',
                'sales_file' => 'required',
            ]);

        // if ($request->isDailyTotals) {
        //     $request->isDailyTotals;// = null;
        // } 
      
// return $request;
        $data = Excel::toArray(new CSVImport, request()->file('sales_file'));       
 
        $userID =  Auth::id();

        $request['userID'] = $userID;

        $sales = new Sales();
        $import_sales = $sales->import_sales_csv($data, $request);
        return $import_sales;

        if (!$import_sales) {
            return redirect()->back()->with('error', 'The uploaded file have incorrect inputs... Please try to upload saless file!!!');
        }
        return redirect()->back()->with('success', 'Uploading saless... Please refresh to see updates!!!'); 
     }

  
    public function show($id)
    {
        //
    }

 
    public function edit($id)
    {
        //
    }

    public function update(Request $request, $id)
    {
        //
    }
 
    public function destroy($id)
    {
        //
    }
}
