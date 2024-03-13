<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
 use App\Mail\StaffLeaveRequestStatus;
use App\Mail\StaffLeaveRequestStatusAdmin;

class UpdateLeaveRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leave_request;
    protected $managers;
   
    public function __construct($leave_request, $managers)
    {
        $this->leave_request = $leave_request;
         $this->managers = $managers;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        
         // send mail to the user requesting leave
         try {
            Mail::to($this->leave_request->email)->send(new StaffLeaveRequestStatus($this->leave_request));
        } catch (\Throwable $e) {
            DB::table('logs')->insert([ 'log' => $e, 'created_at' => now(), ]);
        }
       
        // / send mail to their all user_managers
        foreach ($this->managers as $manager) {
            try {
                Mail::to($manager->email)->send(new StaffLeaveRequestStatusAdmin($this->leave_request, $manager));
            } catch (\Throwable $e) {
                DB::table('logs')->insert([ 'log' => $e, 'created_at' => now(), ]);
            }
        }

    }
}
