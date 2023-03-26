<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Sales;

class save_imported_salesCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $sales;
    public $form;
   
    public function __construct($sales, $form)
    {
        $this->sales = $sales;
        $this->form = $form;
    }
    
    public function float($number = 0)
    {
        // if (!is_numeric($num)) { $num = 0; }
        return number_format(floatval($number));
    }
   
    public function handle()  
    {
        $date_from = date( 'Y-m-d' ,strtotime($this->sales['date_from']));
        $date_to = date( 'Y-m-d' ,strtotime($this->sales['date_to']));
        $date_from = '%'.$date_from.'%';
        $date_to = '%'.$date_to.'%';

        $isDailyTotals = $this->form['isDailyTotals'];
        
        if ($isDailyTotals) {
            $isDailyTotals = true;
        } else {
            $isDailyTotals = false;
        }

        
        $sale = DB::table('sales')
                ->where( [['barcode', '=', $this->sales['code']],
                    ['from', 'LIKE', $date_from],
                    ['to', 'LIKE', $date_to],
                    ['daily_total', '=', $isDailyTotals],
                    ['storeID', '=', intval($this->form['store'])]] )
                ->delete();

        // if ($sale->isEmpty()) { 

            $sales = new Sales();
            $sales->barcode = $this->sales['code']; 
            $sales->descript = $this->sales['descript'];
            $sales->department = $this->sales['department'];
            $sales->mainitem = $this->sales['mainitem'];
            $sales->sales = $this->float($this->sales['sales']);
            $sales->salesCost = $this->float($this->sales['salescost']);
            $sales->reFunds = $this->float($this->sales['refund']);
            $sales->reFundsCost = $this->float($this->sales['refundscost']);
            $sales->nettSales = $this->float($this->sales['nettsales']);
            $sales->profit = $this->float($this->sales['profit']);            
            $sales->vat = $this->float($this->sales['vat']);            
            $sales->from = $this->sales['date_from'];
            $sales->to = $this->sales['date_to'];
            $sales->daily_total = $this->sales['isDailyTotals'];
            $sales->storeID = intval($this->form['store']);
            $sales->userID  = $this->form['userID'];
            $sales->save();

            return true;
        // }

        // update the sale if it exist
        // DB::table('sales')
        // ->where( [['barcode', '=', $this->sales['code']],
        //         ['from', 'LIKE', $date_from],
        //         ['to', 'LIKE', $date_to],
        //         ['daily_total', '=', $this->form['isDailyTotals']],
        //         ['storeID', '=', intval($this->form['store'])]] )
        // ->update([
        //         'sales' => $this->float($this->sales['sales']),
        //         'salesCost' => $this->float($this->sales['salescost']),
        //         'reFunds' => $this->float($this->sales['refund']),
        //         'reFundsCost' => $this->float($this->sales['refundscost']),
        //         'nettSales' => $this->float($this->sales['nettsales']),
        //         'profit' => $this->float($this->sales['profit']), 
        //         'vat' => $this->float($this->sales['vat']), 
        //         ]);
                
        return true;
    }
}

