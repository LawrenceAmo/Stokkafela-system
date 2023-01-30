<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
 use App\Jobs\product_stats;


class Stats extends Model
{
    use HasFactory;

    public function get_products_stats( )
    {
        // Update the products stats via a queue/job
         product_stats::dispatch();

         $products_stats = DB::table('products_stats')->get();
         return $products_stats[0]; 
    }

    public function get_sales_stats( )
    { 
        // Update the products stats via a queue/job
        //  product_stats::dispatch(); 
        $sales = DB::table('products')
        ->get();

        // $stockValue = 0;
        // $total_stock = 0;
        // $total_quantity = 0;
        //  for ($i=0; $i < count($sales) ; $i++) { 

        //    $stockValue += $sales[$i]->avrgcost * $sales[$i]->onhand;
        //    $total_quantity += (int)$sales[$i]->onhand; // you need to change this
        //    $total_stock += (int)$sales[$i]->onhand;
 
        // }

          return $sales;
    }

}
