<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Jobs\import_salesCSV;

class Sales extends Model
{
    use HasFactory;

    public function import_sales_csv($data, $request)
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
         
        if (!$vat) {
            return "aaaaaaaaa";
        }
        return $vat;
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
        //   array_shift($data);  // remove the old headers 
 
         $form = [
                        'userID' => $request->userID,
                        'store' => $request->store,
                        'date_from' => $request->date_from,
                        'date_to' => $request->date_to,
                        'isDailyTotals' => $request->isDailyTotals,
                    ];
                    // \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[1])
    //                 $date = $data[1][0];
    //                 $date = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp( $date));
    return $data[0][8];
    
//  return $this->test($data, $header, $form ); 
import_salesCSV::dispatch($data, $header, $form ); 
// return only wanted fields from data in the excel file.
        return true;
    }

    public function test($data, $header, $form)
    {

        for ($i=0; $i <count($data); $i++) {
            
            // foreach ($this->data as $data) {
                    
                $sales = [  
                    'code' => $data[$i][$header['code']],
                    'descript' => $data[$i][$header['descript']],
                    'mainitem' => $data[$i][$header['mainitem']],
                    'department' => $data[$i][$header['department']],
                    'sales' => $data[$i][$header['sales']],
                    'salescost' => $data[$i][$header['salescost']],
                    'refund' => $data[$i][$header['refund']],
                    'refundscost' => $data[$i][$header['refundscost']],
                    'nettsales' => $data[$i][$header['nettsales']],
                    'profit' => $data[$i][$header['profit']],
                    // 'vat' => $data[$i][$header['vat']],
                 ];

                 return $sales;
                // save_imported_salesCSV::dispatch($sales, $this->form);
                // return $data;
            }

            return $sales;
    }
}
 