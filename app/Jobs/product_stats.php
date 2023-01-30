<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
class product_stats implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    public function __construct()
    {
        //
    }

    public function handle()
    {        
        ini_set("memory_limit","256M");
        ini_set('max_execution_time', 2080);
  
        $products = DB::table('products')
         ->get();
        $stockValue = 0;
        $total_stock = 0;
        $total_quantity = 0;
        $out_of_stock_products = 0;
        for ($i=0; $i < count($products) ; $i++) { 

           $stockValue += floatval($products[$i]->avrgcost) *(int)$products[$i]->onhand;
           $total_quantity += (int)$products[$i]->onhand; // you need to change this
           $total_stock += (int)$products[$i]->onhand;

           if($products[$i]->onhand < 1)
            {
                $out_of_stock_products += 1;
            }
 
        }
 
        DB::table("products_stats")
             ->updateOrInsert(
                [
                    'statsID' => 1
                ],
                [
                    'stock_value' => $stockValue ,
                    'total_stock' => $total_stock ,
                    'stock_onhand' => $total_stock - $out_of_stock_products ,
                    'total_quantity' => $total_quantity ,
                    'out_of_stock_products' => $out_of_stock_products
                ],

            );
    }
}
