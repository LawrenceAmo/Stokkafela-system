<?php

namespace App\Models;

use App\Jobs\CreateProductManufacturers;
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
        $manufacturers = DB::table('manufacturers')                            
                            ->get()->toArray(); 

        // return $stock_analysis;
        $products = DB::table('products')
                        // ->join('manufacturers', 'products.barcode', '=', 'stock_analyses.code')
                        ->where( [['storeID', '=', $storeID]])
                        // ->where( [['barcode', '=', 'amo']])
                        ->orderBy('descript', 'asc')
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

            $first_month = date("m", strtotime("first day of -3 months"));
            $second_month = date("m", strtotime("last day of -2 months"));
            $last_month = date("m", strtotime("last day of -1 months")); 

            // loop, and get total nettsales for each product
            for ($i=0; $i < count( $stock_analysis) ; $i++) { 
                $code = $stock_analysis[$i]->code;
 
               if (!in_array($code, $codes, true)) {
                    array_push($codes, $code);
                    $reports[$code] = [];
                    $reports[$code]['nett_sales'] = 0;
                    $reports[ $code ]['department'] = $stock_analysis[$i]->department;
                    $reports[ $code ]['code'] = $code;
                    $reports[ $code ]['total_sales'] = [];
                    $reports[ $code ]['sales_date'] = [];
                    $reports[ $code ]['first_month'] = 0;
                    $reports[ $code ]['second_month'] = 0;
                    $reports[ $code ]['last_month'] = 0;
                                        
                 }

                if (in_array($code, $codes, true)){ 

                    $reports[$code]['nett_sales'] +=  toFloat($stock_analysis[$i]->nettSales);
                    // $sales_date = array( substr($stock_analysis[$i]->date, 5, 2) => toFloat($stock_analysis[$i]->nettSales));
                    // (int)date('m', strtotime($stock_analysis[$i]->date)) ,  toFloat($stock_analysis[$i]->nettSales)

                    $sales_date = [];
                    $sales_date[ date('m', strtotime($stock_analysis[$i]->date))] =  toFloat($stock_analysis[$i]->nettSales);
                   
                    if (date('m', strtotime($stock_analysis[$i]->date)) == $first_month) {
                        $reports[ $code ]['first_month'] = toFloat($stock_analysis[$i]->nettSales);
                    }
                    if (date('m', strtotime($stock_analysis[$i]->date)) == $second_month) {
                        $reports[ $code ]['second_month'] = toFloat($stock_analysis[$i]->nettSales);
                    }
                    if (date('m', strtotime($stock_analysis[$i]->date)) == $last_month) {
                        $reports[ $code ]['last_month'] = toFloat($stock_analysis[$i]->nettSales);
                    }
 
                    array_push($reports[$code]['total_sales'],  $sales_date   ); 
                    array_push($reports[$code]['sales_date'],  [date('m', strtotime($stock_analysis[$i]->date)), toFloat($stock_analysis[$i]->nettSales)]   ); 

                } 
            }
            return $reports ;
        }
 
        function combine_stockAndSales($products, $stock_analysis, $manufacturers)
        {
            $get_nettsales =  get_nettsales($stock_analysis);
            $manufacturer_product_codes = array_column($manufacturers, 'barcode');

            // loop, and get total nettsales for each product
            for ($i=0; $i < count( $products) ; $i++) { 
                $code = $products[$i]->barcode;
 
                if (array_key_exists($code,  $get_nettsales )){

                    $products[$i]->nett_sales = $get_nettsales[$code]['nett_sales'];
                    $products[$i]->department =  $get_nettsales[$code]['department'];
                    $products[$i]->total_sales =  $get_nettsales[$code]['total_sales'];
                    $products[$i]->sales_date =  $get_nettsales[$code]['sales_date'];
                    $products[$i]->first_month =  $get_nettsales[$code]['first_month'];
                    $products[$i]->second_month =  $get_nettsales[$code]['second_month'];
                    $products[$i]->last_month =  $get_nettsales[$code]['last_month'];
  
                }else{
                    $products[$i]->nett_sales = 0;                     
                    $products[$i]->total_sales = [];                     
                    $products[$i]->sales_date = [];                     
                    $products[$i]->first_month = 0;                     
                    $products[$i]->second_month = 0;                     
                    $products[$i]->last_month = 0;                     
               }
               $manufacturers = array_column($manufacturers, null, "barcode");
            //   return $manufacturers;
               if (in_array($code, $manufacturer_product_codes)) {
                try {
                    $products[$i]->manufacture = $manufacturers[$code]->manufacture;
                } catch (\Throwable $th) {
                    $products[$i]->manufacture = '';
                }
                 
               }else{
                // return 'no manufacturer for '. $code ;
                $products[$i]->manufacture = '';
               }

               $products[$i]->avr_rr = $products[$i]->nett_sales / 3;
               $products[$i]->avrgcost = toFloat($products[$i]->avrgcost );
               $products[$i]->onhand = toFloat($products[$i]->onhand );
               $products[$i]->stock_value = $products[$i]->avrgcost * $products[$i]->onhand;

               if ($products[$i]->avr_rr != 0) {
                    $products[$i]->days_onhand = ( $products[$i]->stock_value / $products[$i]->avr_rr) * 21;
                    $products[$i]->suggested_order = toFloat(( 21 - $products[$i]->days_onhand ) * ( toFloat($products[$i]->avr_rr) / 21 ));
                    $products[$i]->soq = 0;// toFloat( $products[$i]->suggested_order / $products[$i]->avrgcost ) || 0;
               } else {
                    $products[$i]->days_onhand = 0;
                    $products[$i]->suggested_order = 0;
                    $products[$i]->soq = 0;
               } 
            }
 
            return $products ;
        }
        
        return combine_stockAndSales($products, $stock_analysis, $manufacturers);
    }



    // ////////////////////////////
    public function import_manufacturers($data) {

        $data = $data[0];
        $manufacturers = [];
        $header = ['BARCODE', 'DESCRIPTION', 'MANUFACTURERS'];
        array_push($manufacturers, $header); // push only the headers first

        // // get index of wanted data/field
        $BARCODE = array_search('BARCODE', $data[0]);
        $DESCRIPTION = array_search('DESCRIPTION', $data[0]);
        $MANUFACTURERS = array_search('MANUFACTURERS', $data[0]);
 
        $index = [
                    'barcode' => $BARCODE,
                    'description' => $DESCRIPTION,
                    'manufacture' => $MANUFACTURERS,
                ];

                if(
                    !$index['barcode']  &&
                    !$index['description'] &&
                    !$index['manufacture']
                  )
                {
                    return 'File have incorrect Columns, Please make sure you include these columns as they are [BARCODE,DESCRIPTION,MANUFACTURERS]';
                }
                //  return $index;
        // return $manufacturers;

        // return 
        array_shift($data);  // remove the old headers 

        // return $data[127];//[1];

        CreateProductManufacturers::dispatch($data, $index);
        // import_productsCSV::dispatch( $data, $ids, $index);    
         
        // return only wanted fields from data in the excel file.
        return 'success';
    }
}
