<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Imports\CSVImport;
use App\Models\RepSales;
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
        $from = date("Y-m-d", strtotime("first day of 0 months"));
        $to = date("Y-m-d", strtotime("last day of 0 months"));

        $stores = DB::table('stores')->get(['storeID','name']);

        $rep_sales = DB::table('reps')        
            ->join('rep_sales', 'rep_sales.repID', '=', 'reps.repID')
            ->join('destributors', 'destributors.destributorID', '=', 'reps.destributorID')
            ->where([['rep_sales.date', '>=', $from], ['rep_sales.date', '<=', $to]])
            ->orderBy('date', 'DESC')
            ->get(); 
        $reps = DB::table('reps')->get();
 
        return view('portal.sales.index')
        ->with('stores', $stores) //
        ->with('reps', $reps)
        ->with('rep_sales', $rep_sales)
        ->with('get_products_stats', $this->get_products_stats());
    }
 
    public function save(Request $request)
    {
        $request->validate([ 
                'store' => 'required',
                'sales_file' => 'required',
            ]); 

        $data = Excel::toArray(new CSVImport, request()->file('sales_file'));       
 
        $userID =  Auth::id();
        $request['userID'] = $userID;
        $sales = new Sales();
        $import_sales = $sales->import_sales_csv($data, $request);
 
        if (!$import_sales) {
            return redirect()->back()->with('error', 'The uploaded file have incorrect inputs... Please try to upload sales file!!!');
        }
        return redirect()->back()->with('success', 'Uploading saless... Please refresh to see updates!!!'); 
     }

  
    //  view rep sales analysis
    public function sales_analysis( )
    {
        $from = date("Y-m-d", strtotime("first day of 0 months"));
        $to = date("Y-m-d", strtotime("last day of 0 months"));

        $thisMonth = date("Y-m", strtotime("first day of 0 months"));

        $sales = DB::table('reps')
                ->join('rep_targets', 'rep_targets.repID', '=', 'reps.repID')
                ->join('rep_sales', 'rep_sales.repID', '=', 'reps.repID')
                ->join('destributors', 'destributors.destributorID', '=', 'reps.destributorID')
                ->where([['rep_sales.date', '>=', $from], ['rep_sales.date', '<=', $to], ['rep_targets.date', '>=', $from]])
                ->get();

                $reps = DB::table('reps')
                ->leftJoin('rep_targets', function($join) use ($thisMonth){
                    $join->on('reps.repID', '=', 'rep_targets.repID')
                    ->where('rep_targets.date', 'like', $thisMonth.'%');

                }) 
                ->whereNull('rep_targets.targetID')
                ->select('reps.*')
                ->get();
  
        return view('portal.sales.analysis')->with('sales', $sales)->with('reps_with_notargets', $reps);
    }

    // 
    public function create_rep_sale(Request $request)
    { 
        $request->validate([
            'rep' => 'required',
            'nett_sale' => 'required',
            'vat' => 'required',
            'date' => 'required',             
        ]); 
        $date = substr($request->date,0, 10);
       
         $rep = DB::table('rep_sales')
         ->where( 'repID', '=', (int)$request->rep )
         ->where('date', 'like', '%'.$date.'%')
         ->exists(); 

        $rep_data = DB::table('reps')
                ->where([['repID', (int)$request->rep]]) 
                ->get();
 
        if ($rep) {
            return redirect()->back()->with("error", "The sale for Rep ".$rep_data[0]->first_name." at ".$date." already exists!!!");
        } 
 
        $rep_sale = new RepSales();
        $rep_sale->nettSales = $request->nett_sale;
        $rep_sale->VAT = $request->vat;
        $rep_sale->date = $request->date;
        $rep_sale->repID = (int)$request->rep;
        $rep_sale->save();
         
        return redirect()->back()->with('success', 'Sale for Rep: '.$rep_data[0]->first_name.' for: '.$request->date.' was created successfully');
    }
 
    public function update_rep_sale($id, $delete = false)
    {
        $rep_sale = DB::table('rep_sales')
                    ->leftJoin('reps', 'rep_sales.repID', '=', 'reps.repID' )
                    ->where('salesID', $id)
                    ->get();

        return view('portal.sales.edit_repsale')
                ->with('rep_sale', $rep_sale[0])
                ->with('salesID', $id)
                ->with('delete', $delete);
    }
    // update rep sale (Not done yet)
    public function save_rep_sale(Request $request)
    {  
        $request->validate([
            'rep' => 'required',
            'nett_sale' => 'required',
            'vat' => 'required',
            'date' => 'required',             
        ]);   

        DB::table('rep_sales')
              ->where('salesID', $request->salesID)
              ->update([
                'nettSales' => $request->nett_sale,
                'VAT' => $request->vat,
                'date' => $request->date,
            ]);
 
        return redirect()->back()->with('success', 'Sale for this Rep was Updated successfully');
    }

    // 
    public function delete_rep_sale($id)
    {
        DB::table('rep_sales')
              ->where('salesID', $id)
              ->delete();

        return redirect('/portal/sales')->with('success', 'Sale for this Rep was deleted successfully');
    }
 
    
}
