<?php

namespace App\Http\Controllers;

use App\Models\RepTargets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TargetsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function create_rep_target(Request $request)
    { 
        $request->validate([
            'rep' => 'required',
            'target_amount' => 'required',
            // 'date' => 'required',             
        ]); 

        $date = date("Y-m-d", strtotime("first day of 0 months"));
       
         $rep = DB::table('rep_targets')
                ->where( 'repID', '=', (int)$request->rep )
                ->where('date', 'like', '%'.$date.'%')
                ->exists();

        $rep_data = DB::table('reps')
                ->where([['repID', (int)$request->rep]]) 
                ->get();
                // return $rep_data;

        if ($rep) {
            return redirect()->back()->with("error", "The target for Rep ".$rep_data[0]->first_name." at ".$date." already exists!!!");
        } 
 
        $rep_target = new RepTargets();
        $rep_target->target_amount = $request->target_amount;
        $rep_target->date = $date;
        $rep_target->repID = (int)$request->rep;
        $rep_target->save();
         
        return redirect()->back()->with('success', 'Parget for Rep: '.$rep_data[0]->first_name.' for: '.$date.' was created successfully');
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
