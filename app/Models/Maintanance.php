<?php

namespace App\Models;

use App\Jobs\import_stock_analysisCSV;
use App\Jobs\update_stock_analysis_reports;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;


set_time_limit(300);
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

    public function stock_analysis($storeID)
    {
        $from = date("Y-m-d", strtotime("first day of -3 months"));
        $to = date("Y-m-d", strtotime("last day of -1 months"));
 
        $stock_analysis = DB::table('stock_analyses')
                            ->where( [
                                ['date', '>=', $from], ['date', '<=', $to],
                                ['storeID', '=', $storeID]])
                             ->orderBy('date', 'asc')
                            ->get(); 

        $products = DB::table('products')
                        ->where( [['storeID', '=', $storeID]])
                        ->orderBy('onhand', 'DESC')
                        ->get();

            // remove comma from value and convert it to float
            function toFloat($str)
                {
                    return floatval(str_replace(',', '', $str));
                }

        // add all netsales for last 3 month
        function get_nettsales($stock_analysis)
        {
            $codes = []; $reports = []; 
            // loop, and get total nettsales for each product
            for ($i=0; $i < count( $stock_analysis) ; $i++) { 
                $code = $stock_analysis[$i]->code;
 
               if (!in_array($code, $codes, true)) {
                    array_push($codes, $code);
                    $reports[$code] = [];
                    $reports[$code]['nett_sales'] = 0;
                    $reports[ $code ]['department'] = $stock_analysis[$i]->department;
                    $reports[ $code ]['code'] = $code;
                    // $reports[ $code ]['invoices'] = 0;
                    // $reports[ $code ]['purchases'] = 0;
                }
                if (in_array($code, $codes, true)){
  
                $reports[$code]['nett_sales'] +=  toFloat($stock_analysis[$i]->nettSales);
                // $reports[$code]['invoices'] +=  toFloat($stock_analysis[$i]->nettSales);
                // $reports[$code]['purchases'] +=  toFloat($stock_analysis[$i]->nettSales);
                } 
            }
            return $reports ;
        }

        function combine_stockAndSales($products, $stock_analysis)
        {
            $get_nettsales = get_nettsales($stock_analysis);
 
            // loop, and get total nettsales for each product
            for ($i=0; $i < count( $products) ; $i++) { 
                $code = $products[$i]->barcode;
 
                if (array_key_exists($code,  $get_nettsales )){

                    $products[$i]->nett_sales = $get_nettsales[$code]['nett_sales'];
                    $products[$i]->department =  $get_nettsales[$code]['department'];
  
                }else{
                    $products[$i]->nett_sales = 0;                     
               }

               $products[$i]->avr_rr = $products[$i]->nett_sales / 3;
               $products[$i]->avrgcost = toFloat($products[$i]->avrgcost );
               $products[$i]->onhand = toFloat($products[$i]->onhand );
               $products[$i]->stock_value = $products[$i]->avrgcost * $products[$i]->onhand;

               if ($products[$i]->avr_rr != 0) {
                $products[$i]->days_onhand = ( $products[$i]->stock_value / $products[$i]->avr_rr) * 25;
               } else {
                $products[$i]->days_onhand = 0;
               }  

            //    update_stock_analysis_reports::dispatch( $products[$i] );


            //    DB::table('stock_analysis_reports')
            //    ->updateOrInsert(
            //     ['barcode' => $products[$i]->barcode, 'storeID' => $products[$i]->storeID],
            //     [
            //         'barcode' => $products[$i]->barcode,
            //         'descript' => $products[$i]->descript,
            //         // 'sellprice1' => $products[$i]->sellprice1,
            //         'department' => $products[$i]->department,
            //         'sellpinc1' => $products[$i]->sellpinc1,
            //         'onhand' => $products[$i]->onhand,
            //         // 'OnHandAvail' => $products[$i]->OnHandAvail,
            //         'avrgcost' => $products[$i]->avrgcost,
            //         'storeID' => $products[$i]->storeID,
            //         'nett_sales' => $products[$i]->nett_sales,
            //         'avr_rr' => $products[$i]->avr_rr,
            //         'stock_value' => $products[$i]->stock_value,
            //         'days_onhand' => $products[$i]->days_onhand,
            //     ]);
            
            }

            // update_stock_analysis_reports::dispatch( $products );

            return $products ;
        }
        
        return combine_stockAndSales($products, $stock_analysis);



         return $stock_analysis;
    }
}
