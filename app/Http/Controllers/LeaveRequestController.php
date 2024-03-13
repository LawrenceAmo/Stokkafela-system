<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\CreateLeaveRequest;
use App\Jobs\UpdateLeaveRequest;
use App\Models\LeaveRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\StaffLeaveRequest;
use App\Mail\StaffLeaveRequestAdmin;
use App\Mail\StaffLeaveRequestStatus;
use App\Mail\StaffLeaveRequestStatusAdmin;

class LeaveRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userID = Auth::id();
        $leave_requests =  DB::table('leave_requests')        
                                ->leftJoin('users', 'users.id', '=', 'leave_requests.userID')
                                ->leftJoin('users as admin', 'leave_requests.updated_byID', '=', 'admin.id')
                                ->leftJoin('leave_types', 'leave_types.leave_typeID', '=', 'leave_requests.leave_typeID')
                                ->where('leave_requests.userID', '=', (int)$userID )
                                ->select('admin.first_name as admin_name','admin.last_name as admin_surname','users.*','leave_requests.*','leave_types.*')
                                ->orderBy('users.id', 'asc')
                                ->get();

        $leave_balances =  DB::table('leave_types')  
                                ->leftJoin('leave_balances', 'leave_balances.leave_typeID', '=', 'leave_types.leave_typeID')
                                ->where('leave_balances.userID', '=', (int)$userID )
                                // ->select('leave_types.*')
                                ->get();

        $leave_types =  DB::table('leave_types')->get();

        // return  User::find(1)->hasPermission('admin');

        return view('portal.leave.index')->with("leave_balances", $leave_balances)->with("leave_requests", $leave_requests)->with("leave_types", $leave_types); 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function leave_admin()
    {
        $leave_requests =  DB::table('leave_requests')        
                            ->leftJoin('users', 'users.id', '=', 'leave_requests.userID')
                            ->leftJoin('users as admin', 'leave_requests.updated_byID', '=', 'admin.id')
                            ->leftJoin('leave_types', 'leave_types.leave_typeID', '=', 'leave_requests.leave_typeID')
                            // ->where('leave_requests.userID', '=', (int)$userID )
                            ->select('admin.first_name as admin_name','admin.last_name as admin_surname','users.*','leave_requests.*','leave_types.*',
                            DB::raw("CASE WHEN leave_requests.updated_byID IS NULL THEN 'Not yet approved' ELSE admin.id END AS updated_byID"))
                            ->get();

        $leave_balances =  DB::table('leave_balances')        
                            ->leftJoin('leave_types', 'leave_types.leave_typeID', '=', 'leave_balances.leave_balanceID')
                            ->leftJoin('users', 'users.id', '=', 'leave_balances.userID')
                            // ->where('leave_balances.userID', '=', (int)$userID )
                            ->get();
        $leave_types =  DB::table('leave_types')->get();

        return view('portal.leave.leave_admin')->with("leave_balances", $leave_balances)->with("leave_requests", $leave_requests)->with("leave_types", $leave_types); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function leave_request(Request $request)
    {
        $request->validate([
            'selected_leave_type' => 'required',                  
            'date_from' => 'required',                   
            'date_to' => 'required',                   
         ]);

        $userID = Auth::id();
        $leave_balance =  DB::table('leave_balances')
                            ->where('userID',  (int)$userID)
                            ->where('leave_typeID',  (int)$request->selected_leave_type)
                            ->first();

        if (($request->actual_number_of_days_requested > $leave_balance->balance )) {
           return redirect()->back()->with('error', 'You have insufficient leave days');
        }

        try { 
            DB::table('leave_balances')
            ->where('userID', (int)$userID )
            ->where('leave_typeID', (int)$request->selected_leave_type )
            ->update([
                    'balance' => $request->available_leave_days,
            ]);
 
            $leave_request = new LeaveRequest();
            $leave_request->number_of_days_requested = $request->number_of_days_requested;
            $leave_request->actual_number_of_days_requested = $request->actual_number_of_days_requested;
            $leave_request->date_from = $request->date_from;
            $leave_request->date_to = $request->date_to;
            $leave_request->userID = $userID;
            $leave_request->leave_typeID = (int)$request->selected_leave_type;
            $leave_request->description = $request->comments;

            $leave_type =  DB::table('leave_types')
                            ->where('leave_typeID',  (int)$request->selected_leave_type)
                            ->first();
            $user = User::find((int)$userID);
            $user_managers =  DB::table('user_managers')
                                ->leftJoin('users', 'users.id', '=', 'user_managers.managerID')
                                ->where('user_managers.userID',  (int)$userID)
                                ->get();
 
            $leave_request->save(); 

            $leave_type = [
                'date' => now(),
                'leave_type_name' => $leave_type->name,
            ];
 
            CreateLeaveRequest::dispatch($leave_request, $user, $user_managers, $leave_type);

        } catch (\Throwable $th) {

            DB::table('logs')->insert([ 'log' => $th, 'created_at' => now(), ]);
            return redirect()->back()->with('error', 'Something went wrong when creating this Leave application. Our support team has been notified. Please try again or contact us...');
        }
        return redirect()->back()->with('success', 'Your leave application was successful...');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update_leave_request(Request $request)
    {
        $request->validate([
            'status' => 'required',                  
            // 'reason' => 'required',                   
         ]);

        $leave_request = DB::table('leave_requests')->where('leave_requestID', (int)$request->selected_leave_request )->first();
                 
        //  Only update new applications
        if ($leave_request->status !== 'pending') {
            return redirect()->back()->with('error', 'This leave application is already updated. Once a leave application is approved or cancelled you can not update it...');
         }

         try {
                DB::table('leave_requests')
                    ->where('leave_requestID', (int)$request->selected_leave_request )
                    ->update([
                        'status' => $request->status,
                        'reason_to_update' => $request->reason,
                        'updated_byID' => (int)Auth::id(),                        
                        'updated_at' => now(),                        
                    ]);
             
                    if ($request->status !== 'pending') {
                    
                        $oldBalance =  DB::table('leave_balances')
                                            ->where('userID', (int)$leave_request->userID )
                                            ->where('leave_typeID', (int)$leave_request->leave_typeID )
                                            ->first();
                
                        DB::table('leave_balances')
                            ->where('userID', (int)$leave_request->userID )
                            ->where('leave_typeID', (int)$leave_request->leave_typeID )
                            ->update([
                                    'balance' => (float)$oldBalance->balance + (float)$leave_request->actual_number_of_days_requested,
                            ]);
                    }

            $leave_request =  DB::table('leave_requests')
                                ->leftJoin('leave_types', 'leave_types.leave_typeID', '=', 'leave_requests.leave_typeID')
                                ->leftJoin('users', 'users.id', '=', 'leave_requests.userID')
                                ->leftJoin('users as manager', 'users.id', '=', 'leave_requests.updated_byID')
                                ->where('leave_requests.leave_requestID', (int)$request->selected_leave_request )
                                ->select(
                                    'leave_requests.*', 'leave_requests.updated_at as leave_updated_at', 'leave_types.*', 'users.first_name', 'users.last_name', 'users.email',
                                    'manager.first_name as admin_first_name','manager.last_name as admin_last_name',
                                    'manager.email as admin_email'
                                    )
                                ->first();

            $managers =  DB::table('user_managers')
                       ->leftJoin('users', 'users.id', '=', 'user_managers.managerID')
                        ->where('user_managers.userID', (int)$leave_request->userID )
                        ->get();

            UpdateLeaveRequest::dispatch($leave_request, $managers);

            foreach ($managers as $manager) {
                return view('emails.leave.staff_leave_request_status')->with('manager',$manager)->with('data',$leave_request);
            }

        } catch (\Throwable $th) {
            DB::table('logs')->insert([ 'log' => $th, 'created_at' => now(), ]);
            return redirect()->back()->with('error', 'Something went wrong when updating this Leave application. Our support team has been notified. Please try again or contact us...');
         }
         return redirect()->back()->with('success', 'This leave application was updated successfully...');
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
