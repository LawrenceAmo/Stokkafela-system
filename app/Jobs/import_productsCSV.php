<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Jobs\save_imported_productsCSV;

class import_productsCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
 
    protected $data;
    protected $ids;
    protected $index;
  
    public function __construct($data, $ids, $index)
    {
        $this->data = $data;
        $this->ids = $ids;
        $this->index = $index;
    }

    public function handle()
    {
        for ($i=0; $i <count($this->data) ; $i++) { 
            
            $product = [
                'barcode' => $this->data[$i][$this->index['barcode']],
                'descript' => $this->data[$i][$this->index['descript']],
                'avrgcost' => $this->data[$i][$this->index['avrgcost']],
                'onhand' => $this->data[$i][$this->index['onhand']],
                'sellpinc1' => $this->data[$i][$this->index['sellpinc1']],
            ];
            
            save_imported_productsCSV::dispatch( $product, $this->ids );
            // if ($i == 10) {
            //     return true;
            // }
        }
    }
}
