<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class StaffController extends Controller
{
    


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $staffs = DB::table('users')->get();      
        return view('portal.staff.index', ['miniStats'=> $this->get_mini_stats()])->with('staffs', $staffs);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments = DB::table('departments')
        ->join('roles','departments.departmentID','=','roles.departmentID')
        // ->where('stores.storeID', '=', $id)
        ->get();
        $stores = DB::table('stores')->get();      

        // return $stores;
        return view('portal.staff.create', ['departments' => $departments, 'stores' => $stores ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
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
    public function delete_staff($id)
    {
        // return $id;
        $userID = Auth::id();
        $user = User::where('id', '=', $userID )->get();

        // return DB::table('stores')->where('userID', $id)->get();

        if ((int)$userID == (int)$id) {
            return redirect()->back()->with('error', 'You don\'t have access, please contact your Admin');
        }
        if (count($user) > 0) {
            if (str_contains($user[0]->email, 'amo')) { 
                // Disable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                   User::where('id','=',$id)->delete(); 
                // Enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS= 1'); 

                return redirect()->back()->with('success', 'User deleted successfully!!!');

            }
        } 
        return redirect()->back()->with('error', 'You don\'t have access, please contact your Admin');
    }
}
 