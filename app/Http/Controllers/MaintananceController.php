<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\auth_token;
use App\Models\User;
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
    // only for super admin
    public function delete_rep_sale_by_date(Request $request)
    {
        $request->validate([
            'date' => 'required',                  
         ]); 

        $userID = Auth::id();
        $user = User::where('id', '=', $userID )->get();

        if (count($user) > 0) {
            if (str_contains($user[0]->email, 'amo')) {

                DB::table('rep_sales')
                    ->where('date', 'like', $request->date."%")
                    ->delete();
 
                return redirect()->back()->with('success', 'you deleted all sales reps for '.$request->date);

            }
            return redirect()->back()->with('error', 'You don\'t have access, please contact your Admin');
        }

        return redirect()->back()->with('error', 'Something went wrong, please contact your Admin');
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
