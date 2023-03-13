<?php

namespace App\Models;

use App\Jobs\import_stock_analysisCSV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintanance extends Model
{
    use HasFactory;
 
    public function import_stock_analysis_csv($data, $request)
    {
        $data = $data[0];
        $stock_analysis = [];
        $header = ['CODE', 'DESCRIPT', 'INVOICES', 'CRNOTES', 'Department', 'Profit', 'Nettsales', 'Purchases'];
        array_push($stock_analysis, $header); // push only the headers first

        // get index of wanted data/field
        $CODE = array_search('CODE', $data[0]);
        $DESCRIPT = array_search('DESCRIPT', $data[0]);
        $CRNOTES = array_search('CRNOTES', $data[0]);
        $INVOICES = array_search('INVOICES', $data[0]);
        $Department = array_search('Department', $data[0]);
        $Nettsales = array_search('Nettsales', $data[0]);
        $Purchases = array_search('Purchases', $data[0]);
         $Profit = array_search('Profit', $data[0]);

        $index = [ 
            'code' => $CODE,
            'descript' => $DESCRIPT,
            'invoices' => $INVOICES,
            'Department' => $Department,
            'CRNOTES' => $CRNOTES,
            'Nettsales' => $Nettsales,
            'Purchases' => $Purchases,
            'profit' => $Profit,
         ];

        if(
            !$index['code'] &&
            !$index['descript'] &&
            !$index['Nettsales']
  
          )
        {
            return false;
        }

        $form = [
            'userID' => $request->userID,
            'store' => $request->store,
            'date' => date('Y/m/d', strtotime($request->date)),
         ];
 
        array_shift($data);  // remove the old headers 

        import_stock_analysisCSV::dispatch( $data, $form, $index);

         return true;
    }
}
