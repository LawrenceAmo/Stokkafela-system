<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use App\Models\auth_token;
use App\Models\Api_auth;
use App\Imports\CSVImport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB; 
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{    
    public function get_products()
    {
        // $auth = new Api_authenticate();
        // $userID = $auth->api_getUID($request); 
        $products = DB::table('products')
                    ->leftJoin('stores','stores.storeID','=','products.storeID')
                    ->get();
        return $products;
    }

    // ////////////
    public function get_mabebeza_stock()
    { 
        $stores = DB::table('stores')->where('name', 'LIKE', '%abebeza%')->get();
        for ($i=0; $i < count( $stores); $i++) { 
           if ( strpos($stores[$i]->name, 'embisa') || strpos($stores[$i]->name, 'ega') ) {
             $mabebeza_tembisa_storeID =  $stores[$i]->storeID;
           }
           if ( strpos($stores[$i]->name, 'mbanani') || strpos($stores[$i]->name, 'doc') ) {
              $mabebeza_bambanani_storeID =  $stores[$i]->storeID;
           }
        }

        $tembisa = DB::table('products')
                        ->where('storeID', $mabebeza_tembisa_storeID)
                        ->get();

        $bambanani = DB::table('products')
                        ->where('storeID', $mabebeza_bambanani_storeID)
                        ->get();

        return [ 'tembisa' => $tembisa, 'bambanani' => $bambanani ]; 
    }

    public function get_top_products()
    {
        return $this->top_products();
    }

    public function index()
    {
 
        $stores = DB::table('stores')->get(['storeID','name']);
        // $products = DB::table('products')
        // ->leftJoin('stores','stores.storeID','=','products.storeID')
        // // ->get()
        // // ->paginate(10);
        // ->simplePaginate(100);
          
       return view('portal.products.index')
                ->with('stores',$stores)
                ->with('get_products_stats', $this->get_products_stats());
                // ->with('products',$products); //
    }


    public function create()
    {

        return view('portal.products.create') ; //
    }
    
    public function save(Request $request)
    {
        $request->validate([
            'store' => 'required',                  
            'products_file' => 'required',                  
         ]);
 
        $data = Excel::toArray(new CSVImport, request()->file('products_file'));
        $userID =  Auth::id();
        $product = new Product();
        $import_product = $product->import_products_csv($data, ['storeID' => $request->store, 'userID' => $userID]);

        // return $import_product;

        if (!$import_product) {
            return redirect()->back()->with('error', 'The uploaded file have incorrect inputs... Please try to upload products file!!!');
        }
        return redirect()->back()->with('success', 'Uploading products on queue...');
    } 

    public function delete_store_product(Request $request)
    {
        $request->validate([
            'store' => 'required',                  
        ]);
 
        $userID = Auth::id();
        $user = User::where('id', '=', $userID )->get();

        if (count($user) <= 0) {
            if (!str_contains($user[0]->email, 'amo')) {
              return redirect()->back()->with('error', 'You don\'t have access to this function!!!');
            }
          }

          Product::where('storeID', '=', (int)$request->store )->delete();        
        
        return redirect()->back()->with('success', 'All products were deleted for this store...');
    } 
    
}
