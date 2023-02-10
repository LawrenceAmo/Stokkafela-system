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
        if (!$this->form['isDailyTotals']) {
            DB::table('sales')
            ->where([
                    ['from', 'LIKE', $this->form['date_from'].'%'],
                    ['storeID', intval($this->form['store'])],
                    ['daily_total', '=', $this->form['isDailyTotals']],
                    ])
            ->delete();
        }
 
        for ($i=0; $i <count($this->data); $i++) {
  
            $code = $this->data[$i][$this->header['code']];

            if (!$code) {
                $code = 0;
            }

            $sales = [
                'code' => $code,
                'descript' => $this->data[$i][$this->header['descript']],
                'mainitem' => $this->data[$i][$this->header['mainitem']],
                'department' => $this->data[$i][$this->header['department']],
                'sales' => $this->data[$i][$this->header['sales']],
                'salescost' => $this->data[$i][$this->header['salescost']],
                'refund' => $this->data[$i][$this->header['refund']],
                'refundscost' => $this->data[$i][$this->header['refundscost']],
                'nettsales' => $this->data[$i][$this->header['nettsales']],
                'profit' => $this->data[$i][$this->header['profit']],
                'daily_total' => $this->form['isDailyTotals'], 
             ];
            save_imported_salesCSV::dispatch($sales, $this->form); 
        }
    }
}
 
