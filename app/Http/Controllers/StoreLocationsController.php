<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StoreLocations;
use Illuminate\Support\Facades\Storage;

class StoreLocationsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $store = StoreLocations::get();
        return view('portal.store.store_locations')->with('stores', $store);
    }
 
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function save_store_locations(Request $request)
    {
        $request->validate([
            'name' => 'required',                  
            'address' => 'required',                  
         ]);
 
          // Check if the store already exists in the database
        $store = StoreLocations::where('name', $request->name)
                            ->where('address', $request->address)
                            ->first();

        if ($store) {
            return redirect()->back()->with('error', 'This Store Location: "'.$request->name.'" with that address already exists.!!!');
        }
 
        // function that create a uniq name and store the img to storage
        $image_name = $this->upload_store_image( $request->photo );

         // Create the store
        $store = new StoreLocations();
        $store->name = $request->name;
        $store->address = $request->address;
        $store->map_link = $request->map_link;
        $store->lat = $request->lat;
        $store->lng = $request->lng;
        $store->photo = $image_name;
 
        try {
            $store->save();
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error occurred while creating the store.');
        }
 
        return redirect()->back()->with('success', 'The store: "'.$request->name.'"  was created successfully!!!');
    }
 

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $store = StoreLocations::where('store_locationID', $id)->first();
        return view('portal.store.update_store_locations')->with('store', $store);
    }

   
    public function update_store_location(Request $request)
    {

        // return $request;
        $request->validate([
            'name' => 'required',                  
            'address' => 'required',                  
         ]);
 
          // Check if the store already exists in the database
        $store = StoreLocations::where('store_locationID', $request->store_locationID)->first();

        if (!$store) { return redirect()->back()->with('error', 'store not found!!!'); }

        $delete_old_photo = (boolean)$request->delete_photo;
        if ($request->photo) { $delete_old_photo = true;  }

        // Update or delete the photo of the store
        if ($delete_old_photo) {
            // function that create a uniq name and store the img to storage
            $image_name = $this->upload_store_image( $request->photo );
            $oldPhoto =  $store->photo;
            $store->photo = $image_name;
        } 

        // update the store
        $store->name = $request->name;
        $store->address = $request->address;
        $store->lat = $request->lat;
        $store->lng = $request->lng;
        $store->map_link = $request->map_link;
 
        try {
 
            $store->save();
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

    
    public function upload_store_image( $image = null)
    {
            if(!$image) return false;      ///// check if file is available if not do nothing

            $filename = $image->getClientOriginalName();
            $ext = substr($filename,-5);  //get the file extention
            
            $uniqName = md5($filename)."".uniqid($filename, true);      // create a uniq name
            $filename = "st".md5($uniqName)."ore".$ext;             //  add prefix and sufix to the file name

            $image->storeAs('stores/',"$filename",'public');        // store file

        return $filename;
    }
}
