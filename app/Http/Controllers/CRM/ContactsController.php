<?php

namespace App\Http\Controllers\CRM;

use App\Http\Controllers\Controller;
use App\Models\AccountContacts;
use App\Models\Accounts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ContactsController extends Controller
{
       /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $account_contacts =  AccountContacts::leftJoin('accounts', 'accounts.accountID', 'account_contacts.accountID')
                                ->select('account_contacts.*', 'accounts.company_name as company_name')
                                ->get();
        // return $account_contacts;
        return view('portal.crm.contacts.index')->with('contacts', $account_contacts); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $data=[])
    {
        $accounts =  DB::table('accounts')->get();    

        if (!$request->has([
            'first_name' , 'last_name'// , 'child_name' , 'child_surname' , 'reciept' , 'email' , 'cell_number' , 'store' , 'photo' ,
         ])) {
            $data = [
                'first_name' => '',
                'last_name' => '',
                'position' => '',
                'phone' => '',
                'alt_phone' => '',
                'email' => '',
                'alt_email' => '',
                'date_of_birth' => '',
                'street' => '',
                'suburb' => '',
                'city' => '',
                'state' => '', 
                'country' => '', 
                'zip_code' => '', 
                'description' => '', 
            ];
          }  
        return view('portal.crm.contacts.create')->with('accounts', $accounts)->with('data',$data); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create_store(Request $request)      // create new contact
    {        
        // return $request;

        $request->validate([
            'accountID' => 'required',  
            'first_name' => 'required|string',  
            'last_name' => 'required', 
            'phone' => 'nullable|numeric', 
            'alt_phone' => 'nullable|numeric',  
            'email' => 'nullable|email',  
            'alt_email' => 'nullable|email',  
        ], [
            'phone.numeric' => 'The phone number must be a number.',
            'accountID.required' => 'Please select account where this user belongs to.',
            'email.email' => 'The email must be a valid email address.',
        ]);
                
        $contact = new AccountContacts();
        $contact->first_name = $request->first_name;
        $contact->last_name = $request->last_name;
        $contact->title = $request->title;
        $contact->position = $request->position;
        $contact->accountID = $request->accountID;
        $contact->phone = $request->phone;
        $contact->alt_phone = $request->alt_phone;
        $contact->email = $request->email;
        $contact->alt_email = $request->alt_email;
        $contact->gender = $request->gender;
        $contact->date_of_birth = $request->date_of_birth;
        $contact->street = $request->street;
        $contact->suburb = $request->suburb;
        $contact->city = $request->city;
        $contact->state = $request->state;
        $contact->country = $request->country;
        $contact->zip_code = $request->zip_code;
        $contact->notes = $request->description;
        $contact->status = $request->status;
        $contact->marketing_opt_in = $request->marketing_opt_in;
        $contact->preferred_contact_method = $request->preferred_contact_method;

        $account = Accounts::find((int) $request->accountID); 

        try {
            $contact->save();

            return redirect( route('crm_contacts') )->with('success', 'contact for '.$account->company_name.' was created successfully');
        } catch (\Throwable $th) {
            throw $th;
            return redirect()->back()->with('error', 
                'There was an error, when trying to create '.$account->company_name.' contact, Our support team has been notified.'.$th);
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
        $account = AccountContacts::findOrFail((int) $id); 
        $industries =  DB::table('industries')->get();
        // return $account;
        return view('portal.crm.contacts.update')->with('account', $account)->with('industries', $industries);  
    }

    public function update_save(Request $request)
    {
        return $request;
        $request->validate([ 
            'company_name' => 'required|string',  
            'company_name' => 'required|string',  
        ]);

// annual_revenue	null
// number_of_employees	null
// account_type	"Business"
// preferred_contact_method	"email"
// marketing_opt_in	"1"
// accountID	"1"
// description	null

        $account = AccountContacts::findOrFail((int) $request->accountID);
        $account->first_name = $request->first_name;
        $account->last_name = $request->last_name;
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
