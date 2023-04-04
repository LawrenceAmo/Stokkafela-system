<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Destributors;
use Illuminate\Support\Facades\DB;

class DestributorsController extends Controller
{
 

    // Create a new DESTRIBUTOR
    public function create_destributor(Request $request)
    { 
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'store' => 'required',             
        ]); 

        $dest = DB::table('destributors')
            ->where( 'name', '=', $request->name  )
            ->exists();

         if ($dest) {
            return redirect()->back()->with("error", "The Destributor ".$request->trading_name." already exists!!!");
        }  

        $des = new Destributors();
        $des->name = $request->name;
        $des->address = $request->address;
        $des->storeID = (int)$request->store;
        $des->save();
         
        return redirect()->back()->with('success', 'Destribution Center: '.$request->name.' with region: '.$request->address.' was created successfully');
    }

    // /////////////////////// View update form
    public function update_destributor($id, $delete = false)
    {          
        $stores = DB::table('stores')->get();
        
        $des = DB::table('destributors')
                     ->where('destributorID', $id)
                    ->get();
  
        return view('portal.debtors.edit_des')
                ->with('des', $des[0])
                ->with('stores', $stores)
                ->with('delete', $delete);
    }

    // save update
    public function save_destributor(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'address' => 'required|string',
            'storeID' => 'required',           
        ]);
    
         DB::table('destributors')
                    ->where('destributorID', $request->destributorID)
                    ->update([
                        'name' => $request->name,
                        'address' => $request->address,
                        'storeID' => (int)$request->storeID,
                    ]);
         
        return redirect()->back()->with('success', 'This Destributor: '.$request->name.' was Updated successfully');
    } 
    

    // 
    public function delete_destributor($id)
    {
        $reps =  DB::table('reps')
                    ->where('destributorID', $id)
                    ->exists();

        if ($reps) {
            return redirect()->back()->with('error', 'This Destributor have Reps, You can\'t delete Destributor with Reps. Delete all Reps for this Destributor first and try again...');
        }
 
        DB::table('reps')
              ->where('repID', $id)
              ->delete();

        return redirect('/portal/sales')->with('success', 'Rep was deleted successfully');
    }
}
