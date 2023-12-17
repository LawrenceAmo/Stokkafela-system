<?php

namespace App\Models;

use App\Jobs\import_productsCSV;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isEmpty;

class Product extends Model
{ 
    use HasFactory;

    public function import_products_csv($data, $ids)
    {
        $data = $data[0];
        $products = [];
        $header = ['CODE', 'DESCRIPT', 'SELLPINC1', 'AVRGCOST', 'ONHAND'];
        array_push($products, $header); // push only the headers first

        // get index of wanted data/field
        $BARCODE = array_search('CODE', $data[0]);
        $DESCRIPT = array_search('DESCRIPT', $data[0]);
        $AVRGCOST = array_search('AVRGCOST', $data[0]);
        $SELLPINC1 = array_search('SELLPINC1', $data[0]);
        $ONHAND = array_search('ONHAND', $data[0]);

        $index = [
                    'barcode' => $BARCODE,
                    'descript' => $DESCRIPT,
                    'avrgcost' => $AVRGCOST,
                    'onhand' => $ONHAND,
                    'sellpinc1' => $SELLPINC1,
                ];

                if(
                    !$index['barcode']  &&
                    !$index['descript'] &&
                    !$index['avrgcost'] &&
                    !$index['onhand']   &&
                    !$index['sellpinc1'] 
                  )
                {
                    return false;
                }
                //  return $index;

        array_shift($data);  // remove the old headers 

        // return $data;

        import_productsCSV::dispatch( $data, $ids, $index);
 
        // return only wanted fields from data in the excel file.
        return true;
    }
 
    public function save_products_csv(array $product, array $ids)
    {
        $productExist = DB::table('products')
                ->where( [['storeID', '=', intval($ids['storeID'])], ['barcode', '=', $product['barcode']]] )
                ->get();     
                        
        if ($productExist->isEmpty()) {
            // create new product
                $products = new Product();
                $products->barcode = $product['barcode'];
                $products->descript = $product['descript'];
                $products->avrgcost = $product['avrgcost'];
                $products->onhand = $product['onhand'];
                $products->sellpinc1 = $product['sellpinc1'];
                // $products->GP_1 = $product['GP_1'];
                // $products->onhandlvl1 = $product['onhandlvl1'];
                // $products->OnHandAvail = $product['OnHandAvail'];
                $products->storeID = intval($ids['storeID']);
                $products->userID  = $ids['userID'];
                $products->save();
                return $product;
            return "this product does not exist";
        }

        // update the product if it exist
            DB::table('products')
            ->where( [['storeID', '=', $ids['storeID']], ['barcode', '=', $product['barcode']]] )
            ->update([
                'descript' => $product['descript'],
                'avrgcost' => $product['avrgcost'],
                'onhand' => $product['onhand'],
                'sellpinc1' => $product['sellpinc1'],
                // 'GP_1' => $product['GP_1'],
                // 'onhandlvl1' => $product['onhandlvl1'],
                // 'OnHandAvail' => $product['OnHandAvail'],
                ]);
        return "this product exist";
    }
}
