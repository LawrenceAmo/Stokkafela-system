<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Auth_token;
use App\Models\Contacts;
use App\Models\Login;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;

class StaffController extends Controller
{
    public function index()
    {
       $staffs = DB::table('users')
                ->leftjoin('user_roles', 'user_roles.userID', '=', 'users.id')
                ->leftjoin('roles', 'roles.roleID', '=', 'user_roles.roleID')
                ->leftjoin('departments', 'departments.departmentID', '=', 'roles.departmentID')
                ->select('users.*', 'roles.*', 'user_roles.*', 'departments.name as department_name')
                ->get();      

       return view('portal.staff.index')->with('staffs', $staffs);
    }

    
    public function create()
    {
        $departments = DB::table('departments')
        ->join('roles','departments.departmentID','=','roles.departmentID')
        ->get();
        $stores = DB::table('stores')->get();      

       return view('portal.staff.create', ['departments' => $departments, 'stores' => $stores ]);
    }


    public function save_staff(Request $request)
    {
        $request->validate([
            'first_name'  => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);
 
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name, 
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        Contacts::create([ 'userID' => $user->id, ]);

        $login = new Login(); // show that user logged in
        $login->email = $request->email;
        $login->status = true;  // successfully registered and logged in.
 
        $token = new Auth_token();
        $token->authenticated = false;
        $token->userID = $user->id;
        $token->save();

        event(new Registered($user)); 
        return redirect()->route('staff')->with('success', 'User created successfully');
    }
 
    public function show($id)
    {
    }
 
    public function edit($id)
    {

        $user = User::where('id',(int)$id)
                    ->leftjoin('contacts', 'contacts.userID', '=', 'users.id')
                    ->leftjoin('user_roles', 'user_roles.userID', '=', 'users.id')
                    ->leftjoin('roles', 'roles.roleID', '=', 'user_roles.roleID')
                    ->leftjoin('departments', 'departments.departmentID', '=', 'roles.departmentID')
                    ->first();
                    
        $roles = DB::table('roles')->get();

        return view('portal.staff.update')->with('user', $user)->with('roles', $roles);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_staff_profile(Request $request)
    {
        $role_status = (Boolean)$request->role_status;

        User::where('id', (int)$request->id)
        ->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name, 
            'email' => $request->email,
            'phone' => $request->phone,
         ]);

         DB::table('contacts')
         ->where('userID', (int)$request->id)
        ->update([
            'street' => $request->street,
            'suburb' => $request->suburb, 
            'city' => $request->city,
            'state' => $request->state,
            'country' => $request->country,
            'zip_code' => $request->zip_code,
            'phone' => $request->phone,
         ]);

         if ($role_status) {
            DB::table('user_roles')
            ->updateOrInsert(
                ['userID' => (int)$request->id], // Unique identifier column and value
                [
                    'userID' => (int)$request->id,
                    'roleID' => (int)$request->role,
                    'role_status' =>  $role_status,
                    'updated_at' => now(),
                ]);

            // return redirect()->back()->with('error', 'Please add a Staff Role...');
        }
         
        return redirect()->back()->with('success', 'User data updated successfully');
    }

    public function delete_staff($id)
    {

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
 