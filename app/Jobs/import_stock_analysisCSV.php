<?php
namespace App\Jobs;

use App\Models\Stock_analysis;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class import_stock_analysisCSV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $data;
    public $form;
    public $index;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $form, $index)
        {
            $this->data = $data;
            $this->form = $form;
            $this->index = $index;
        }

        public function float($number = 0)
        {
            // if (!is_numeric($num)) { $num = 0; }
            return number_format(floatval($number));
        }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(120);

        $date = date( 'Y-m-d' ,strtotime($this->form['date']));
        $date = '%'.$date.'%';
        $storeID = intval($this->form['store']); 

        DB::table('stock_analyses')
                ->where( [
                    ['date', 'LIKE', $date],
                    ['storeID', '=', $storeID]] )
                ->delete();

        for ($i=0; $i <count($this->data); $i++) { 

            $code = $this->data[$i][$this->index['code']];

            if (!$code) {  $code = 0;   }
       
            $Stock_analysis = new Stock_analysis();
            $Stock_analysis->code = $this->data[$i][$this->index['code']]; 
            $Stock_analysis->descript = $this->data[$i][$this->index['descript']];
            $Stock_analysis->department = $this->data[$i][$this->index['Department']];
            $Stock_analysis->invoices = $this->data[$i][$this->index['invoices']];
            $Stock_analysis->CRNOTES = $this->data[$i][$this->index['CRNOTES']];
            $Stock_analysis->purchases = $this->data[$i][$this->index['Purchases']];
            $Stock_analysis->nettSales = $this->float($this->data[$i][$this->index['Nettsales']]);
            $Stock_analysis->profit = $this->float($this->data[$i][$this->index['profit']]);            
            $Stock_analysis->date = $this->form['date'];
            $Stock_analysis->storeID = $storeID;
            $Stock_analysis->userID  = $this->form['userID'];
            $Stock_analysis->save();

         }
    }
}
