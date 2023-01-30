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
    
    public function float($num = 0)
    {
        // if (!is_numeric($num)) { $num = 0; }
        return number_format(floatval($num));
    }
  
    public function handle() 
    {
        $sale = DB::table('sales')
        ->where( [['barcode', '=', $this->sales['code']],
                  ['from', '=', $this->form['date_from']],
                  ['storeID', '=', intval($this->form['store'])]] )
        ->get();

        if ($sale->isEmpty()) {

            $sales = new Sales();
            $sales->barcode = $this->sales['code'] || 99;
            $sales->department = $this->sales['department'];
            $sales->mainitem = $this->sales['mainitem'];
            $sales->sales = $this->float($this->sales['sales']);
            $sales->salesCost = $this->float($this->sales['salescost']);
            $sales->reFunds = $this->float($this->sales['refund']);
            $sales->reFundsCost = $this->float($this->sales['refundscost']);
            $sales->nettSales = $this->float($this->sales['nettsales']);
            $sales->profit = $this->float($this->sales['profit']);
            $sales->from = $this->form['date_from'];
            $sales->to = $this->form['date_from'];
            $sales->storeID = intval($this->form['store']);
            $sales->userID  = $this->form['userID'];
            $sales->save();

            return true;
        }
        
        // update the sale if it exist
        DB::table('sales')
        ->where( [['barcode', '=', $this->sales['code']],
                  ['from', '=', $this->form['date_from']],
                  ['storeID', '=', intval($this->form['store'])]] )
        ->update([
            'sales' => $this->float($this->sales['sales']),
            'salesCost' => $this->float($this->sales['salescost']),
            'reFunds' => $this->float($this->sales['refund']),
            'reFundsCost' => $this->float($this->sales['refundscost']),
            'nettSales' => $this->float($this->sales['nettsales']),
            'profit' => $this->float($this->sales['profit']), 
            ]);
        return true;
    }
}

 