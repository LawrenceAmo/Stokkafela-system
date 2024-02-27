<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class LeaveTypeController extends Controller
{
     
    public function create_leave_type(Request $request)
    {
        $validationRules = [
            'leave_type_name' => 'required',
            'expire_in' => 'required|numeric|min:0',
            'allocated_days' => 'required|numeric|min:0',
        ];

        // Additional validation rules for creating leave type
        if ($request->create_type || $request->leave_typeID === null) {
            $validationRules['leave_type_name'] = '|unique:leave_types,name';
        }

        $request->validate($validationRules);

         // create Leave type
         if ($request->create_type || $request->leave_typeID === null) {

                    $leave_type = new LeaveType();
                    $leave_type->name = $request->leave_type_name;
                    $leave_type->expire_in_days = $request->expire_in;
                    $leave_type->days = $request->allocated_days;
                    $leave_type->accumulation_rate = $request->accumulation_rate;
                    $leave_type->accumulation_period = $request->accumulation_period;
                    $leave_type->description = $request->description;

                try {
                    $leave_type->save();
                } catch (\Throwable $th) {
                    return redirect()->back()->with('error', 'Something went wrong when creating a Leave type. Please try again...');
                }
                    return redirect()->back()->with('success', 'Leave type created successfully...');
          }

        try {
            DB::table('leave_types')
                ->where('leave_typeID', (int)$request->leave_typeID )
                ->update([
                    'name' => $request->leave_type_name,
                    'expire_in_days' => $request->expire_in,
                    'days' => $request->allocated_days,
                    'accumulation_rate' => $request->accumulation_rate,
                    'accumulation_period' => $request->accumulation_period,
                    'description' => $request->description,
                ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong when Updating this Leave type. Please try again...');
        }
            return redirect()->back()->with('success', 'Leave type updated successfully...');        
    }

  
    public function leave_balances()
    {
        $leave_types =  DB::table('leave_types')->get();
        $staffs =  DB::table('users')->get();

        $leave_balances = new LeaveType();
        $leave_balances = $leave_balances->staff_leave_balances();

        return view('portal.leave.leave_balance')->with("leave_balances", $leave_balances)->with("leave_types", $leave_types)->with("staffs", $staffs); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function create_staff_leave_balance(Request $request)
    {
        $request->validate([
            'leave_type' => 'required',                  
            'balance' => 'required',                   
            'staff' => 'required',                   
        ]); 

        $leave_type_balance = DB::table('leave_balances')
                                ->where('userID', (int)$request->staff )
                                ->where('leave_typeID',  (int)$request->leave_type)->get();

        if (!$leave_type_balance->isEmpty()) {
            return redirect()->back()->with('error', 'This staff already have balance for this leave...');
        }

         try {

            DB::table('leave_balances')->insert([
                'leave_typeID' => $request->leave_type,
                'userID' => (int)$request->staff,
                'balance' => $request->balance,
                'comment' => $request->description,
                'updated_at' => now(),
                'created_at' => now(),
            ]);

         } catch (\Throwable $th) {
           return redirect()->back()->with('error', 'Something went wrong when creating a Leave type balance. Please try again...');
         }
         return redirect()->back()->with('success', 'Staff leave balance created successfully...');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_staff_leave_balance(Request $request)
    {

        $validationRules = [
            'leave_type' => 'required',
            'balance' => 'required|numeric|min:0',
            'reason_to_edit' => 'required',
        ];
        $request->validate($validationRules);

        try {

            $oldLogs = DB::table('leave_balances')
                            ->where('userID', (int)$request->userID )
                            ->where('leave_balanceID', (int)$request->leave_type )
                            ->first();

            $logs = $oldLogs->logs;
            if (!$logs) {
                $logs = [];
            }else{
                $logs = json_decode($logs, true);
            }

            $user = Auth::user();
            // Append new data
            $newLogs = [
                'reason_to_edit' => $request->reason_to_edit,
                'user' => $user->first_name.' '.$user->last_name.' - '.$user->email.' ',
                'old_balance' => $oldLogs->balance,
                'new_balance' => $request->balance,
                'date' => now(),
            ];

             array_push($logs, $newLogs);
            // return $logs;

            DB::table('leave_balances')
            ->where('userID', (int)$request->userID )
            ->where('leave_balanceID', (int)$request->leave_type )
            ->update([
                    'balance' => $request->balance,
                    'comment' => $request->description,
                    'logs' => $logs,
                ]);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'Something went wrong when Updating this Leave type Balance. Please try again...'.$th);
        }
            return redirect()->back()->with('success', 'Leave type balance updated successfully...'); 
    }

}
