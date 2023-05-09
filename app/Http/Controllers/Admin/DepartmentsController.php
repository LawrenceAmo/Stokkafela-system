<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\MiniStatistics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
{
 
    //
    public function index()
    {  
        $departments = DB::table('departments')->get();
        
        $roles = DB::table('roles')
        ->Join('departments','departments.departmentID','=','roles.departmentID')
        ->get();
        // return $roles;

        return view('portal.departments.index')->with('roles',$roles)->with('departments',$departments);
    } 

    // 
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',                  
         ]);
 
         $department = new Department();
         $department->name = $request->name;
         $department->other_names = $request->other_names;
         $department->active = $request->active;
         $department->save();
        return redirect()->back();
    }

    public function delete(int $id = null)
    {
         DB::table('departments')->where('departmentID', '=', $id)->delete();
         return redirect()->back()->with('success', 'The Department was deleted successfuly!');
    }

    // 
    public function edit(int $id)
    {
        $department = DB::table('departments')->where('departmentID', '=', $id)->get();
        return view('portal.departments.edit',  ['miniStats'=> $this->get_mini_stats()])->with('id',$id)->with('department',$department[0]);
    }
    
    //  
    public function save(Request $request)
    {
        // return $request->id;
        DB::table('departments')
            ->where('departmentID', '=', $request->id)
            ->update([
                'name' => $request->name,
                'other_names' => $request->other_names,
                'active' => $request->active 
            ]);

            return redirect()->to('portal/departments')->with('success', 'The Department was Updated successfuly!');
    }
}
