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
        $sales = DB::table('products')->get();
 
          return $sales;
    }

    // get top peforming products
    public function top_products(int $storeID = 17)
        { 
            // get all product codes that have more sales.
           $sales = DB::select(
                        "SELECT `barcode`, COUNT(`barcode`) AS `code` FROM `sales`
                         WHERE `from` > ? AND `to` < ? AND `storeID` = ? GROUP BY `barcode` ORDER BY `code` DESC LIMIT 10", 
                        [
                            date_sub(now(),date_interval_create_from_date_string("31 days")),
                            date_sub(now(),date_interval_create_from_date_string("1 days")),
                            $storeID
                        ]
                    );

            // Get only codes
            $codes = array_column($sales, 'barcode'); 
            $products = DB::table('products')->whereIn('barcode', $codes)->get();
 
            return $products;
        } 
}
 