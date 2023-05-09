<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
     
    public function create_Role(Request $request)
     {
         $request->validate([
            'role_title' => 'required',                  
            // 'description' => 'required|string',                  
            'department' => 'required|string',                  
        ]);
        // return $request;

          $role = new Role();
          $role->role_title = $request->role_title;
          $role->description = $request->description;
          $role->departmentID = $request->department;
          $role->save();

         return redirect()->back()->with('success', 'Role was created successfully!!!');
     }
   
     
     public function update_role(int $id)
    {
        $role = DB::table('roles')->where('roleID', '=', $id)->get();
        $departments = DB::table('departments')->get();
        return view('portal.departments.role_edit')->with('role',$role[0])->with('departments',$departments);
    }
    
    //  
    public function save_role(Request $request)
    { 
        $request->validate([
            'role_title' => 'required',                  
            // 'description' => 'required|string',                  
            'department' => 'required|string',                  
        ]);

        DB::table('roles')
            ->where('roleID', '=', $request->roleID)
            ->update([
                'role_title' => $request->role_title,
                'description' => $request->description,
                'departmentID' => $request->department
            ]);

            return redirect()->to('portal/departments')->with('success', 'The Role was Updated successfuly!');
    }

   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
         DB::table('roles')->where('roleID', '=', $id)->delete();
         return redirect()->back()->with('success', 'The Role was deleted successfuly!');
     }
}
