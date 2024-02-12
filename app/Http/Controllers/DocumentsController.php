<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;
use App\Models\Documents;
use Illuminate\Support\Facades\Storage;
class DocumentsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $documents =  DB::table('documents')        
                    ->leftJoin('users', 'users.id', '=', 'documents.userID')
                    ->get();

        return view('portal.documents.index')->with("documents", $documents); 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required',                  
            'file' => 'required',                   
         ]);
         $userID = Auth::id();

         $filename =  $this->upload_document($request->file);

         $file = $request->file('file');
    
        // Get file size in kilobytes
        $fileSize = number_format($file->getSize() / 1024 / 1024, 2);
        
        // Get file type
        $fileType = $file->getMimeType();
        
         $doc = new Documents();
         $doc->name = $request->name;
         $doc->url = $filename;
         $doc->size = $fileSize;
         $doc->type = $fileType;
         $doc->userID = $userID;
         $doc->save();

        //  return $doc;
       return redirect()->back()->with('success', 'Document uploaded successfully!!!');
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

    public function delete_doc($id)
    {
        $documents = DB::table('documents')->where('documentID', (int)$id)->first();
        
        DB::table('documents')->where('documentID', (int)$id)->delete();
        if ($this->delete_document($documents->url)) {
            return redirect()->back()->with('success', 'Document ['.$documents->name.'] was deleted successfully!!!');
        } 
            return redirect()->back()->with('error', 'There was a pronlem deleting this document, please try again or contact support team...');     
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload_document( $image = null)
    {
            if(!$image) return false;      ///// check if file is available if not do nothing

            $filename = $image->getClientOriginalName();
            $ext = substr($filename,-5);  //get the file extention
                        
            $uniqName = md5($filename)."".uniqid($filename, true);      // create a uniq name
            $filename = "doc".md5($uniqName)."file".$ext;             //  add prefix and sufix to the file name

            $image->storeAs('documents/',"$filename",'public');        // store file

        return $filename;
    }

    // delete  file
    public function delete_document($filename)
    {
        // Check if the file exists
        if (Storage::disk('public')->exists('documents/' . $filename)) {
            // Delete the file
            Storage::disk('public')->delete('documents/' . $filename);
            return true; // File deleted successfully
        } else {
            return false; // File does not exist
        }
    }
}
