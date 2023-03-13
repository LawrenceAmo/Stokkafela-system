<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\auth_token;
use App\Models\Product;
use App\Imports\CSVImport;
use App\Models\Maintanance;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MaintananceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $stores = DB::table('stores')->get();

        return view('portal.maintanance.index')
                ->with('stores', $stores);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function stock_analysis(Request $request)
    {
        $request->validate([
            'store' => 'required',                  
            'date' => 'required',                  
            'file' => 'required',                   
         ]);
          
        $data = Excel::toArray(new CSVImport, request()->file('file'));       
 
        $userID =  Auth::id();
        $request['userID'] = $userID;

        $maintanance = new Maintanance();
        $stock_analysis = $maintanance->import_stock_analysis_csv($data, $request);

        // return $request;
        // return $import_product;
        if (!$stock_analysis) {
            return redirect()->back()->with('error', 'The uploaded file have incorrect inputs... Please try to upload sales file!!!');
        }
        return redirect()->back()->with('success', 'Task placed in queue, You can continue with your tasks while we work on this task!!!'); 
     

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
