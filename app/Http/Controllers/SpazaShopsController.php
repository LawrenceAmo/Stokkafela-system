<?php

namespace App\Http\Controllers;

use App\Models\Reps;
use Illuminate\Http\Request;
use App\Models\SpazaShops;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SpazaShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $shops = DB::table('spaza_shops')
                    ->leftjoin('reps', 'spaza_shops.repID', '=', 'reps.repID')
                    ->select('spaza_shops.*', 'reps.repID', 'reps.first_name', 'reps.last_name')
                    ->get();

        $reps = Reps::where('belong_to_stokkafela', true)->get();

        return view('portal.spaza_shops.index')
                    ->with('shops', $shops)
                    ->with('reps', $reps);
    }
 

    /**
     * Store a newly created shop in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_spaza_shops(Request $request)
    {
         $request->validate([
            'name' => 'required',                  
            'address' => 'required',                  
         ]);
 
          // Check if the shop name already exists in the database
        $shop = SpazaShops::where('name', $request->name)->first();

        if ($shop) {
            return redirect()->back()->with('error', 'This shop: "'.$request->name.'"  already exists.!!!');
        }
 
        // function that create a uniq name and store the img to storage
        $image_name = $this->upload_shop_image( $request->photo );

         // Create the shop
        $shop = new SpazaShops();
        $shop->name = $request->name;
        $shop->repID = $request->rep;
        $shop->address = $request->address;
        $shop->lat = $request->lat;
        $shop->lng = $request->lng;
        $shop->photo = $image_name;

        try {
            $shop->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the shop.');
        }
 
        return redirect()->back()->with('success', 'The shop: "'.$request->name.'"  was created successfully!!!');
    }

    public function upload_spaza_shops(Request $request)
    {
         $request->validate([
            'file' => 'required|file',                  
          ]);
 
          // Check if the shop name already exists in the database
        // $shop = SpazaShops::where('name', $request->name)->first();

        return redirect()->back()->with('error', 'This feature is not yet available!!!');

        // if ($shop) {
        //     return redirect()->back()->with('error', 'This shop: "'.$request->name.'"  already exists.!!!');
        // }
  
         // Create the shop
        $shop = new SpazaShops();
        $shop->name = $request->name;
        $shop->repID = $request->rep;
        $shop->address = $request->address;
        $shop->lat = $request->lat;
        $shop->lng = $request->lng;
 
        try {
            $shop->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the shop.');
        }
 
        return redirect()->back()->with('success', 'The shop: "'.$request->name.'"  was created successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function spaza_shop_view($id)
    {
        $shop = SpazaShops::where('spaza_shopID', $id)->first();
 
        // checks if the selected shop is available
        if (!$shop) { return redirect()->back()->with('error', 'Shop not found.'); }

        $reps = Reps::where('belong_to_stokkafela', true)->get();

        return view('portal.spaza_shops.update')->with('shop', $shop)->with('reps', $reps); 
    }

    public function update_spaza_shop(Request $request)
    {
        $request->validate([
            'name' => 'required',                  
            'address' => 'required',                  
         ]);
 
          // Check if the shop already exists in the database
        $shop = SpazaShops::where('spaza_shopID', $request->spaza_shopID)->first();

        if (!$shop) { return redirect()->back()->with('error', 'Shop not found!!!'); }

        $delete_old_photo = (boolean)$request->delete_photo;
        if ($request->photo) { $delete_old_photo = true;  }

        // Update or delete the photo of the shop
        if ($delete_old_photo) {
            // function that create a uniq name and store the img to storage
            $image_name = $this->upload_shop_image( $request->photo );
            $oldPhoto =  $shop->photo;
            $shop->photo = $image_name;
        } 

        // update the shop
        $shop->name = $request->name;
        $shop->address = $request->address;
        $shop->lat = $request->lat;
        $shop->lng = $request->lng;
        $shop->repID = $request->rep;
 
        try {
 
            $shop->save();
            if ($delete_old_photo) {
                $file_path = 'spazashops/'.$oldPhoto; 
                Storage::disk('public')->delete($file_path);
            }
            
         } catch (\Exception $e) {
            return $e;
            return redirect()->back()->with('error', 'An error occurred while updating the shop.');
         }
 
        return redirect()->back()->with('success', 'The shop: "'.$request->name.'"  was updated successfully!!!');
    }
 

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function spaza_shop_delete($id)
    {
        $shop = SpazaShops::where('spaza_shopID', $id)->first();
 
            if (!$shop) { return redirect()->back()->with('error', 'Shop not found.'); }

            try {
                // delete the shop from DB
                SpazaShops::where('spaza_shopID', $id)->delete();

                // Delete the photo for this spaza shop
                $file_path = 'spazashops/'.$shop->photo; 
                Storage::disk('public')->delete($file_path); 

            } catch (\Exception $e) {
                 return redirect()->back()->with('error', 'An error occurred while deleting the spaza shop.');
            }

            return redirect()->back()->with('success', 'The shop: "'.$shop->name.'" was deleted successfully.');
    } 

    public function upload_shop_image( $image = null)
    {
            if(!$image) return false;      ///// check if file is available if not do nothing

            $filename = $image->getClientOriginalName();
            $ext = substr($filename,-5);  //get the file extention
            
            $uniqName = md5($filename)."".uniqid($filename, true);      // create a uniq name
            $filename = "spaza".md5($uniqName)."shop".$ext;             //  add prefix and sufix to the file name

            $image->storeAs('spazashops/',"$filename",'public');        // store file

        return $filename;
    }
}
