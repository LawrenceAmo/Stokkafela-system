<?php
namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class import_salesCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $data;
    public $header;
    public $form;
  
    public function __construct($data, $header, $form)
    {
        $this->data = $data;
        $this->header = $header;
        $this->form = $form;
    }

    public function handle()
    {
        DB::table('sales')
            ->where('from', 'LIKE', $this->form['date_from'].'%')
            ->delete();

        for ($i=0; $i <count($this->data); $i++) {
                            
            $sales = [  
                'code' => $this->data[$i][$this->header['code']],
                'descript' => $this->data[$i][$this->header['descript']],
                'mainitem' => $this->data[$i][$this->header['mainitem']],
                'department' => $this->data[$i][$this->header['department']],
                'sales' => $this->data[$i][$this->header['sales']],
                'salescost' => $this->data[$i][$this->header['salescost']],
                'refund' => $this->data[$i][$this->header['refund']],
                'refundscost' => $this->data[$i][$this->header['refundscost']],
                'nettsales' => $this->data[$i][$this->header['nettsales']],
                'profit' => $this->data[$i][$this->header['profit']],
             ];
            save_imported_salesCSV::dispatch($sales, $this->form);
 
        }
    }
}
 