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
        $store = Store::get();       
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
     * Show store data. Get that from ID or request
     */
    public function show(Request $request, $id = 0)
    { 
        $id == true ? $storeID = $id : $storeID = 0;

        // Check user filter, if not set, set filter request values to default
        if($request>isEmpty() || !$request->from || !$request->to || !$request->store){
            $from = date_sub(now(), date_interval_create_from_date_string("30 days"));   // get last 30 days date
            $from = date_format($from, 'Y-m-d');

            $to = date_sub(now(), date_interval_create_from_date_string("1 days"));      // Go 1 day back, 
            $to = date_format($to, 'Y-m-d');
        }else{

            // get values from request
            $from = $request->from;
            $to = $request->to;
            $storeID = $request->store;
        }

            $stores = DB::table('stores')->get(); // remove limit to show all stores
            $selected_store = $this->get_store($stores, $storeID); 
            $storeID = $selected_store->storeID;
 
            $salesdata = DB::table('sales')
                            ->where( [['from', '>=', $from], ['to', '<=', $to],
                                    ['storeID', '=', $storeID]])
                            ->orderBy('from', 'asc')
                            ->get();

            $sales = array_sum( array_column($salesdata->toArray(), 'sales') );
            $nettsales = array_sum( array_column($salesdata->toArray(), 'nettSales') );

        return view('portal.store.store')
                ->with('salesdata', $salesdata)
                ->with('dates', [ 'from' => $from, 'to' => $to])
                ->with('sales', $sales)
                ->with('storeID', $storeID)
                ->with('stores', $stores)
                ->with('selected_store', $selected_store)
                ->with('nettsales', $nettsales)
                ->with('get_products_stats', $this->get_products_stats());
    }

   
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
