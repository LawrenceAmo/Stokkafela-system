<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class save_imported_productsCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;
    protected $ids;
 
    public function __construct($product, $ids)
    {
        $this->product = $product;
        $this->ids = $ids;
     }
 
    public function handle()
    {
        $productExist = DB::table('products')
                        ->where( [['storeID', '=', intval($this->ids['storeID'])], ['barcode', '=', $this->product['barcode']]] )
                        ->get();     

        if ($productExist->isEmpty()) {
            // create new product
                $products = new Product();
                $products->barcode = $this->product['barcode'];
                $products->descript = $this->product['descript'];
                $products->avrgcost = number_format($this->product['avrgcost'],2);
                $products->onhand = $this->product['onhand'];
                $products->sellpinc1 = number_format($this->product['sellpinc1'],2); 
                $products->storeID = intval($this->ids['storeID']);
                $products->userID  = $this->ids['userID'];
                $products->save();
                // return $product;
            return true;
        }

    // update the product if it exist
        DB::table('products')
        ->where( [['storeID', '=', $this->ids['storeID']], ['barcode', '=', $this->product['barcode']]] )
        ->update([
            'descript' => $this->product['descript'],
            'avrgcost' => $this->product['avrgcost'],
            'onhand' => $this->product['onhand'],
            'sellpinc1' => $this->product['sellpinc1'], 
            ]);
    return true;
    }
}
