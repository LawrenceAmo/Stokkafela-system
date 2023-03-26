<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Jobs\save_stock_analysis_reports;
set_time_limit(360);

class update_stock_analysis_reports implements ShouldQueue
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

    
    public function handle()
    {
        // for ($i=0; $i < count($this->product); $i++) { 
            save_stock_analysis_reports::dispatch( $this->product );            
        // }
    }
}


