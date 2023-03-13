<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
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
        return redirect()->back()->with('success', 'Uploading products... Please refresh to see updates!!!');
    } 
   
    public function edit($id)
    {
        //
    }
 
    public function update(Request $request, $id)
    {
        //
    }

  
    public function destroy($id)
    {
        //
    }
}
