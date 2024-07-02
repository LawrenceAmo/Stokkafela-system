<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccountsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() 
    {
        $accounts = DB::table('accounts')
                            ->leftJoin('account_contacts', function($join) {
                                $join->on('accounts.accountID', '=', 'account_contacts.accountID');
                                    // ->first();
                            })
                            ->join('reps', 'reps.repID', '=', 'accounts.repID')
                            ->select('accounts.*','reps.*',
                                    'account_contacts.first_name as contact_name', 
                                    'account_contacts.last_name as contact_surname', 
                                    'account_contacts.email as contact_email', 
                                    'account_contacts.phone as contact_phone')
                            ->get();

            // return $accounts;
        return view('portal.crm.accounts.index')->with('accounts', $accounts); 
    }

    public function view(int $id) 
    {
        $account = DB::table('accounts')
                            ->leftJoin('account_contacts', function($join) {
                                $join->on('accounts.accountID', '=', 'account_contacts.accountID');
                                    // ->first();
                            })
                            ->join('reps', 'reps.repID', '=', 'accounts.repID')
                            ->where('accounts.accountID', '=', $id)
                            ->select('accounts.*','reps.*',
                                    'account_contacts.first_name as contact_name', 
                                    'account_contacts.last_name as contact_surname', 
                                    'account_contacts.email as contact_email', 
                                    'account_contacts.phone as contact_phone')
                            ->first();

            // return $account;
        return view('portal.crm.accounts.view')->with('account', $account); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $data=[])
    {
        $industries =  DB::table('industries')->get();
        $reps =  DB::table('reps')
        ->join('destributors', 'destributors.destributorID', '=', 'reps.destributorID')
        ->join('stores', 'stores.storeID', '=', 'reps.storeID')
        ->select('reps.*', 'stores.*', 'destributors.name as destributor_name')
        ->get();
        
        if (!$request->has([
            'first_name' , 'last_name'
         ])) {
            $data = [
                'company_name' => '',
                'registration_number' => '',
                'annual_revenue' => '',
                'phone' => '',
                'number_of_employees' => '',
                'email' => '',
                'street' => '',
                'suburb' => '',
                'city' => '',
                'state' => '', 
                'country' => '', 
                'zip_code' => '', 
                'description' => '', 
            ];
          }  

        //   return $reps;
        return view('portal.crm.accounts.create')->with('industries', $industries)->with('data',$data)->with('reps',$reps); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_store(Request $request) // Save data
    {
        $request->validate([
            'rep' => 'required',  
            'company_name' => 'required|string|unique:accounts,company_name',  
        ]);

        // return $request;
        $account = new Accounts();
        $account->company_name = $request->company_name;
        $account->registration_number = $request->registration_number;
        $account->phone = $request->phone;
        $account->email = $request->email;
        $account->annual_revenue = $request->annual_revenue;
        $account->number_of_employees = $request->number_of_employees;
        $account->account_type = $request->account_type;
        $account->street = $request->street;
        $account->suburb = $request->suburb;
        $account->city = $request->city;
        $account->state = $request->state;
        $account->country = $request->country;
        $account->zip_code = $request->zip_code;
        $account->notes = $request->description;
        $account->industryID = $request->industry;
        $account->repID = $request->rep;
        $account->marketing_opt_in = $request->marketing_opt_in;
        $account->preferred_contact_method = $request->preferred_contact_method;

        try {
            $account->save();
            return redirect()->back()->with('success', 'Account for '.$request->company_name.' was created successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 
                'There was an error, when trying to create '.$request->company_name.' Account, Our support team has been notified.'.$th);
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(int $id)
    {
        $account = Accounts::findOrFail((int) $id); 
        $industries =  DB::table('industries')->get();
        return view('portal.crm.accounts.update')->with('account', $account)->with('industries', $industries);  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_save(Request $request)
    {
        $request->validate([
            'company_name' => 'required|string',  
        ]);

        $account = Accounts::findOrFail( (int) $request->accountID );

        // return $account;        
        $account->company_name = $request->company_name;
        $account->registration_number = $request->registration_number;
        $account->phone = $request->phone;
        $account->email = $request->email;
        $account->annual_revenue = $request->annual_revenue;
        $account->number_of_employees = $request->number_of_employees;
        $account->account_type = $request->account_type;
        $account->street = $request->street;
        $account->suburb = $request->suburb;
        $account->city = $request->city;
        $account->state = $request->state;
        $account->country = $request->country;
        $account->zip_code = $request->zip_code;
        $account->notes = $request->description;
        $account->industryID = $request->industry;
        $account->marketing_opt_in = $request->marketing_opt_in;
        $account->preferred_contact_method = $request->preferred_contact_method;

        try {
            $account->save();
            return redirect()->to( route('crm_accounts') )->with('success', 'Account for '.$request->company_name.' was Updated successfully');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 
                      'There was an error, when trying to update '.$request->company_name.' Account, Our support team has been notified.'.$th);
        }
    }
}
