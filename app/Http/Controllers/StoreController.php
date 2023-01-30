<?php

namespace App\Http\Controllers;

use App\Models\Contacts;
use App\Models\Plans;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\Constraint\IsEmpty;
use App\Models\MiniStatistics;

use function PHPUnit\Framework\isEmpty;

class StoreController extends Controller
{
    private function userID(){
        return Auth::id();
    }

    // 
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // try {
            $store = Store::get();
            // return $store;
        // } catch (\Throwable $th) {
        //     return view('portal.store.create')->with('error', "You don't have store. Please create store now.");
        // }
        // $test = DB::table('test')->where('id','>',10)->limit(1000)->get();
        // $contact = Contacts::where('storeID', '=', $store->storeID)->get();
        // return $contact;
        return  view('portal.store.index', ['miniStats'=> $this->get_mini_stats()])->with('stores', $store);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    { 
        // try {
        //     $store = Store::where('userID', '=', $this->userID())->get();
        //     $store = $store[0];
        // } catch (\Throwable $th) {
            return view('portal.store.create');
        // }
        return redirect()->back()->with("error","You already have a store. To create additional store please contact the administrator");       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save(Request $request)
    {
        // return $request;
         $request->validate([
                    'store_name' => 'required|string',
                    'trading_name' => 'required|string',
                    // 'slogan' => 'required|string',
                    // 'zip_code' => 'required',
                    // 'street' => 'required|string',
                 ]);


        $userID = Auth::id();
        // $planID = Plans::where('name', '=', 'trial')->limit(1)->get('planID');
       
        // // if($request->terms_and_conditions){
        // //     return redirect()->back();
        // // } 
        // if(count($planID) > 0){
        //      $planID =  $planID[0]-> planID;
        // }else{
            $planID = 1;
        // } 

        // Create new store
        $store = new Store();
        $store->name = $request->store_name;
        $store->trading_name = $request->trading_name;
        $store->slogan = $request->slogan;
        $store->discription = $request->description;
        $store->userID = $userID;
        $store->save();

        // Create the Contact details for a store
        $contact = new Contacts();
        $contact->storeID = $store->id;
        $contact->phone = $store->phone;
        $contact->alt_email = $store->email;
        $contact->street = $store->street;
        $contact->suburb = $store->suburb;
        $contact->city = $store->city;
        $contact->state = $store->pronvince;
        $contact->country = $store->country;
        $contact->zip_code = $store->zip_code;
        $contact->userID = $userID;
        $contact->store = true;
        $contact->save();

        return redirect()->to('/portal/stores')->with("success", "The store was created successfully!!!");
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
        $store = DB::table('stores')
                    ->join('contacts','stores.storeID','=','contacts.storeID')
                    ->where('stores.storeID', '=', $id)
                    ->get();
        // return $store;
        return view('portal.store.update')->with('store',$store[0]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        // return $request;
        try {
            $store = Store::where('storeID', '=', $request->storeID)->get();
            $store = $store[0];
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', "We don't find this store. Please contact your Admin.");
        }
  
         DB::table('stores')
                ->where('storeID', $request->storeID)  // find your user by their email
                // ->where('userID', Auth::id())  // find your user by their email
                ->limit(1)  // optional - to ensure only one record is updated.
                ->update([
                    'name' => $request->name,
                    'trading_name' => $request->trading_name,
                    'slogan' => $request->slogan,
                    'discription' => $request->description,                       
                ]); 
                
         DB::table('contacts')
                    // ->where('userID', Auth::id())  // find your user by their email
                    ->where('storeID', $request->storeID)  // find your user by their email
                    ->where('store', true)  // find your user by their email
                    ->limit(1)   
                    ->update([
                        'phone' => $request->phone,
                        'alt_email' => $request->email,
                        'street' => $request->street,
                        'suburb' => $request->suburb,
                        'city' => $request->city,
                        'state' => $request->pronvince,                       
                        'country' => $request->country,                       
                        'zip_code' => $request->zip_code,                       
                    ]);
        return redirect()->to('/portal/stores')->with('success','Store Info updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // return $id;
        DB::table('stores')
            ->join('contacts','stores.storeID','=','contacts.storeID')
            ->where('stores.storeID', '=', $id)
            ->delete();
        
        return redirect()->back()->with('success', 'The store was DELETED successfully!...');
    }
}
