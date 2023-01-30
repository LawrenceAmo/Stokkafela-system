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
                // return $header;
         array_shift($data);  // remove the old headers 

         $form = [
                        'userID' => $request->userID,
                        'store' => $request->store,
                        'date_from' => $request->date_from,
                        'date_to' => $request->date_to,
                    ];

                    // temp
                    $sales = 0;
                    for ($x=0; $x < count($data); $x++) { 
                        $sales += $data[$x][4];
                    }
  
    // return $sales;
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
                 ];

                 return $sales;
                // save_imported_salesCSV::dispatch($sales, $this->form);
                // return $data;
            }

            return $sales;
    }
}




// {"uuid":"b8ef2842-3623-49fd-8012-4eb24a3fc1bd",
//     "displayName":"App\\Jobs\\save_imported_salesCSV",
//     "job":"Illuminate\\Queue\\CallQueuedHandler@call",
//     "maxTries":null,
//     "maxExceptions":null,
//     "failOnTimeout":false,
//     "backoff":null,
//     "timeout":null,
//     "retryUntil":null,
//     "data":{"commandName":"App\\Jobs\\save_imported_salesCSV",
//         "command":"O:31:\"App\\Jobs\\save_imported_salesCSV\":2:{s:5:\"sales\";a:10:{s:4:\"code\";s:13:\"6009805070090\";s:8:\"descript\";s:23:\"PITSANA MAIZE MEAL 80KG\";s:8:\"mainitem\";N;s:10:\"department\";s:3:\"017\";s:5:\"sales\";i:1360;s:9:\"salescost\";i:1255;s:6:\"refund\";i:0;s:11:\"refundscost\";i:0;s:9:\"nettsales\";i:1360;s:6:\"profit\";i:105;}s:4:\"form\";a:4:{s:6:\"userID\";i:7;s:5:\"store\";s:2:\"17\";s:9:\"date_from\";s:10:\"2023-01-19\";s:7:\"date_to\";s:10:\"2023-01-19\";}}"}}


