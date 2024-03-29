<?php

namespace App\Http\Controllers;

use App\Models\Destributors;
use App\Models\Reps;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RepsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reps = DB::table('reps')
        ->join('destributors', 'destributors.destributorID', '=', 'reps.destributorID')
        ->get();

        $destributors = DB::table('destributors') 
        ->get();
        $stores = DB::table('stores') 
        ->get();
        // return $destributors;
        return view('portal.debtors.index')->with('reps', $reps)->with('destributors', $destributors)->with('stores', $stores);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create_rep(Request $request)
    { 
        $request->validate([
            'first_name' => 'required|string', 
            'destributor' => 'required',             
        ]); 
       
        $rep = DB::table('reps')
        ->where([ ['first_name', $request->first_name], ['destributorID', $request->destributor] ])
        ->exists();

        // Check if the rep already exist
        if ($rep) {
            return redirect()->back()->with("error", "The Rep ".$request->first_name." with Rep Number: ".$request->rep_number." already exists!!!");
        }

        $last_name = $request->last_name;   
        $rep_number = $request->rep_number;  
        $belong_to_stokkafela = (boolean)$request->belong_to_stokkafela;  

        if (!$last_name)  { $last_name = ''; }        
        if (!$rep_number) { $rep_number = 0; }

        $store = DB::table('destributors')
        ->where('destributorID', $request->destributor) 
        ->get();

        $rep = new Reps();
        $rep->first_name = $request->first_name;
        $rep->last_name = $last_name;
        $rep->rep_number = $rep_number;
        $rep->belong_to_stokkafela = $belong_to_stokkafela;
        $rep->storeID = (int)$store[0]->storeID;
        $rep->destributorID = (int)$request->destributor;
        $rep->save();

        return redirect()->back()->with('success', 'Rep: '.$request->first_name.' with Rep number: '.$request->rep_number.' was created successfully');
    }
 
    
    public function update_rep($id, $delete = false)
    {
        $destributors = DB::table('destributors')->get();
                    
        $rep = DB::table('reps')
                     ->where('repID', $id)
                    ->get();
// return 1;
        return view('portal.debtors.edit_rep')
                ->with('rep', $rep[0])
                ->with('destributors', $destributors)
                ->with('delete', $delete);
    }
    
    // update rep sale (Not done yet)
    public function save_rep(Request $request)
    {  
        $request->validate([
            'first_name' => 'required|string',
            // 'last_name' => 'required|string',
            // 'rep_number' => 'required',
            'destributor' => 'required',           
        ]); 
 
        $last_name = $request->last_name;   
        $rep_number = $request->rep_number;  
        $belong_to_stokkafela = (boolean)$request->belong_to_stokkafela;

        if (!$last_name) {
            $last_name = '';
        }
        
        if (!$rep_number) {
            $rep_number = 0;
        }
        // return $request;
        DB::table('reps')
              ->where('repID', $request->repID)
              ->update([
                'first_name' => $request->first_name,
                'last_name' => $last_name,
                'rep_number' => $rep_number,
                'belong_to_stokkafela' => $belong_to_stokkafela,
                'destributorID' => $request->destributor,                 
            ]);
 
        return redirect()->back()->with('success', 'This Rep: '.$request->first_name.' was Updated successfully');
    } 

    public function delete_rep($id)
    {
        $sales =  DB::table('rep_sales')
                    ->where('repID', $id)
                    ->exists();

        if ($sales) {
            return redirect()->back()->with('error', 'This Rep have sales, You can\'t delete Reps with sales. Delete all sales for this Rep first and try again...');
        }
 
        DB::table('reps')
              ->where('repID', $id)
              ->delete();

        return redirect('/portal/debtors')->with('success', 'Rep was deleted successfully');
    }
}

 