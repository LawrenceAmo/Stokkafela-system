<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class save_stock_analysis_reports implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $product;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        DB::table('stock_analysis_reports')
        ->updateOrInsert(
         ['barcode' => $this->product->barcode, 'storeID' => $this->product->storeID],
         [
             'barcode' => $this->product->barcode,
             'descript' => $this->product->descript,
             'department' => $this->product->department,
             'sellpinc1' => $this->product->sellpinc1,
             'onhand' => $this->product->onhand,
             'avrgcost' => $this->product->avrgcost,
             'storeID' => $this->product->storeID,
             'nett_sales' => $this->product->nett_sales,
             'avr_rr' => $this->product->avr_rr,
             'stock_value' => $this->product->stock_value,
             'days_onhand' => $this->product->days_onhand,
         ]);
    }
}
