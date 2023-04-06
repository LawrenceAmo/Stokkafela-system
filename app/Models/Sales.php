<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\import_salesCSV;

class Sales extends Model
{
    use HasFactory;

    public function import_sales_csv($data, $request, $rep_sales = false)
    {
        $data = $data[0];
        $products = []; 

        $header = ['CODE', 'Descript', 'DEPARTMENT', 'MAINITEM', 'Sales', 'SalesCost', 'Refunds', 'RefundsCost', 'NettSales', 'Profit'];
        array_push($products, $header); // push only the headers first

        // get index of wanted data/field
        $CODE = array_search('CODE', $data[0]); 
        $Descript = array_search('Descript', $data[0]);
        $MAINITEM = array_search('MAINITEM', $data[0]);
        $DEPARTMENT = array_search('DEPARTMENT', $data[0]);
        $Sales = array_search('Sales', $data[0]);
        $SalesCost = array_search('SalesCost', $data[0]);
        $Refunds = array_search('Refunds', $data[0]);
        $RefundsCost = array_search('RefundsCost', $data[0]);
        $NettSales = array_search('NettSales', $data[0]);
        $Profit = array_search('Profit', $data[0]);
        $vat = array_search('VAT', $data[0]);
        $date = array_search('Date', $data[0]);
        $rep_number = array_search('Rep', $data[0]);
             
    //  make the index for the sales
        $header = [
                    'code' => $CODE, 
                    'descript' => $Descript,
                    'mainitem' => $MAINITEM,
                    'department' => $DEPARTMENT,
                    'sales' => $Sales,
                    'salescost' => $SalesCost,
                    'refund' => $Refunds,
                    'refundscost' => $RefundsCost,
                    'nettsales' => $NettSales,
                    'profit' => $Profit,
                    'vat' => $vat,
                    'date' => $date,
                    'rep_number' => $rep_number,
                ];

                //  check if the headeres are correct or not
                if(
                    !$header['code'] &&
                    !$header['descript'] &&
                    !$header['mainitem'] &&
                    !$header['department'] &&
                    !$header['sales'] &&
                    !$header['salescost'] &&
                    !$header['refund'] &&
                    !$header['refundscost'] &&
                    !$header['nettsales'] &&
                    !$header['profit']
                   )
                {
                    return false;
                }

        array_shift($data);  // remove the old headers 

        // for importing rep sales only
        if ($rep_sales) {
            return [$data, $header];
        }

        if (!$vat && $request->isDailyTotals) {
            return false;
        }
 
        $form = [
                    'userID' => $request->userID,
                    'store' => $request->store,
                    'date_from' => $request->date_from,
                    'date_to' => $request->date_to,
                    'isDailyTotals' => $request->isDailyTotals,
                ];

        import_salesCSV::dispatch($data, $header, $form );

// return only wanted fields from data in the excel file.
        return true;
    }
 
}
  