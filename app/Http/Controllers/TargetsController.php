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
            'repID' => 'required',
            'target_amount' => 'required',
            // 'date' => 'required',             
        ]); 

        // return $request;
        $date = date("Y-m-d", strtotime("first day of 0 months"));
         
            $rep = DB::table('rep_targets')
                ->where([['repID', '=', (int)$request->repID], ['date', 'like', $date.'%']] )
                ->exists();

 
           if ($rep) {

                DB::table('rep_targets')
                ->where([['repID', '=', (int)$request->repID], ['date', 'like', $date.'%']] )
                ->update([
                    'target_amount' => $request->target_amount,
                 ]);
           }
            else
           {
                $rep_target = new RepTargets();
                $rep_target->target_amount = $request->target_amount;
                $rep_target->date = $date;
                $rep_target->repID = (int)$request->repID;
                $rep_target->save();
         }
                  
        return redirect()->back()->with('success', 'Target for this month was created successfully');
    }

    public function update_rep_target(int $id)
    {
        $date = date("Y", strtotime("first day of 0 months"));

        $rep = DB::table('rep_targets')
                ->join('reps', 'reps.repID', '=', 'rep_targets.repID')
                ->join('destributors', 'destributors.destributorID', '=', 'reps.destributorID')
                ->where([['rep_targets.repID', '=', (int)$id], ['rep_targets.date', 'like', $date.'%']] )
                ->get();
        
        // return $rep;
        return view('portal.sales.rep_target')->with('rep', $rep[0]);
    }

    public function save_rep_target(Request $request)
    { 
        $request->validate([
            'repID' => 'required',
            'target_amount' => 'required',
         ]); 

        // return $request;
        $date = date("Y", strtotime("first day of 0 months"));
         
            $rep = DB::table('rep_targets')
                ->where([['repID', '=', (int)$request->repID], ['date', 'like', $date.'%']] )
                ->exists();

 
           if ($rep) {

                DB::table('rep_targets')
                ->where([['repID', '=', (int)$request->repID], ['date', 'like', $date.'%']] )
                ->update([
                    'target_amount' => $request->target_amount,
                 ]);
           }
            else
           {
                $rep_target = new RepTargets();
                $rep_target->target_amount = $request->target_amount;
                $rep_target->date = $date;
                $rep_target->repID = (int)$request->repID;
                $rep_target->save();
         }
                  
        return redirect()->back()->with('success', 'Target for this month was Updated successfully');
    }
 

    public function create_rep_target_bydes(Request $request)
    { 
        $request->validate([
            'des' => 'required',
            'target_amount' => 'required',
         ]); 

        $date = date("Y-m-d", strtotime("first day of 0 months"));
        // $date = now()->firstOfMonth();
        
        $reps = DB::table('reps')
                ->where([['destributorID', (int)$request->des]]) 
                ->get('repID');
  
         for ($i=0; $i < count($reps) ; $i++) { 
            // rmm 
            // remote management 

            $rep = DB::table('rep_targets')
                ->where( 'repID', '=', (int)$reps[$i]->repID )
                ->where('date', 'like', '%'.$date.'%')
                ->exists();

           if ($rep) {

                DB::table('rep_targets')
                ->where('repID', '=', (int)$reps[$i]->repID )
                ->where('date', 'like', $date.'%')
                ->update([
                    'target_amount' => $request->target_amount,
                    'date' => $date.'-01'
                ]);
           }
            else
           {
                $rep_target = new RepTargets();
                $rep_target->target_amount = $request->target_amount;
                $rep_target->date = $date;
                $rep_target->repID = (int)$reps[$i]->repID;
                $rep_target->save();
         }
        } 

         
        return redirect()->back()->with('success', 'Target for this month was created successfully');
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
 
 
}
