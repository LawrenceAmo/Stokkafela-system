<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Models\Test;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
            DB::table('test')->insert([
                'name' => 'Amo',
                'date' => now(),
                'num' => 2,
             ]);
        })->everyMinute( );

        // 
        $schedule->call(function () {
            // Get all leave types
            // $leaveTypes = DB::table('leave_types')->get();
    
            // // Loop through each leave type
            // foreach ($leaveTypes as $leaveType) {
            //     // Update leave balances for each user with the specified leave type
            //     DB::table('leave_balances')
            //         ->where('leave_typeID', $leaveType->leave_typeID)
            //         ->increment('balance_in_days', $leaveType->accumulation_rate);
            // }
        })->monthlyOn( );





    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
