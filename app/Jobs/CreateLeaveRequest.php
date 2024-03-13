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
use App\Mail\StaffLeaveRequest;
use App\Mail\StaffLeaveRequestAdmin;
use App\Mail\StaffLeaveRequestStatus;
use App\Mail\StaffLeaveRequestStatusAdmin;

class CreateLeaveRequest implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $leave_request;
    protected $user;
    protected $user_managers;
    protected $leave_type;
  
    public function __construct($leave_request,$user, $user_managers, $leave_type)
    {
        $this->leave_request = $leave_request;
        $this->user = $user;
        $this->user_managers = $user_managers;
        $this->leave_type = $leave_type;
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
            Mail::to($this->user->email)->send(new StaffLeaveRequest($this->leave_request, $this->user, $this->leave_type ));
        } catch (\Throwable $e) {
            DB::table('logs')->insert([ 'log' => $e, 'created_at' => now(), ]);
        }
       
        // / send mail to their all user_managers
        foreach ($this->user_managers as $manager) {
            try {
                Mail::to($manager->email)->send(new StaffLeaveRequestAdmin($this->leave_request, $this->user, $manager, $this->leave_type));
            } catch (\Throwable $e) {
                DB::table('logs')->insert([ 'log' => $e, 'created_at' => now(), ]);
            }
        }

    }
}
