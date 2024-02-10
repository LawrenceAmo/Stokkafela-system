<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CreateProductManufacturers implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $index;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(array $data, array $index)
    {
        $this->data = $data;
        $this->index = $index;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $data = $this->data;
        $index = $this->index;
        
        try {
            for ($i=0; $i < count($data) ; $i++) { 


                try {

                    if ($data[$i][$index['manufacture']]) {
                        DB::table('manufacturers')->updateOrInsert(
                            ["barcode" => $data[$i][$index['barcode']]], // Unique column and value to identify the record
                            [
                                "barcode" => $data[$i][$index['barcode']],
                                "description" => $data[$i][$index['description']],
                                "manufacture" => $data[$i][$index['manufacture']],
                                "created_at"  => now(),
                                "updated_at"  => now(),
                            ]                
                          );
                    } else {
                        DB::table('manufacturers')->updateOrInsert(
                            ["barcode" => $data[$i][$index['barcode']]], // Unique column and value to identify the record
                            [
                                "barcode" => $data[$i][$index['barcode']],
                                "description" => $data[$i][$index['description']],
                                // "manufacture" => $data[$i][$index['manufacture']],
                                "created_at"  => now(),
                                "updated_at"  => now(),
                            ]                
                          );
                    }
                    
                        
                } catch (\Throwable $th) {
                    
                    DB::table('manufacturers')->where('barcode', $data[$i][$index['barcode']])->delete();
                    // Attempt to insert a new record with the same barcode
                    DB::table('manufacturers')->insert([
                        "barcode" => $data[$i][$index['barcode']],
                        "description" => $data[$i][$index['description']],
                        "manufacture" => $data[$i][$index['manufacture']],
                        "created_at" => now(),
                        "updated_at" => now()
                    ]);
                }

            }
        } catch (\Throwable $th) {
            // return 'An unexpected error occurred: ' . $th->getMessage();
        }
    }
}
