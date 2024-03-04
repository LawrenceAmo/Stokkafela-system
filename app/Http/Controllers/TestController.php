<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\MyMail;
use Illuminate\Support\Facades\Mail;
class TestController extends Controller
{
    public function mailtest() {
         
         return view('emails.leave.staff_leave_request');
        
        // Mail::to('amocodes@gmail.com')->send(new MyMail()); //customer_order_shipping
    }
}
