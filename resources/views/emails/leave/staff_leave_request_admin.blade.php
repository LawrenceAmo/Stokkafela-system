<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Stokkafela Leave Management System</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            /* background-color: #94d2ec; */
        }
        .mail-conatiner{
            /* background-color: #ebe7e8; */
            border: 1px solid #4d4633;
            border-radius: 10px;
            padding: 20px;
        }
        a{
            color: #3b95da;
        }
        td{
            padding-right: 20px;
        }
    </style>
     
</head>
<body>
    <div class="mail-conatiner">
        <p class="">Dear <b class="font-weight-bold"> 
            {{$manager->first_name}} {{$manager->last_name}} 
        </b>,</p>
        <p>A new leave request has been submitted through the leave tracker system.</p>
        <b>Here are the details:</b>

        <table class="table">
            <tbody>  
                <tr>
                    <td>Employee</td>
                    <td><b>{{$user->first_name}} {{$user->last_name}}</b></td>
                </tr> 
                <tr>
                    <td>Leave Type</td>
                    <td><b>{{$leave_type['leave_type_name']}}</b></td>
                </tr>  
                <tr>
                    <td>Start Date</td>
                    <td><b>{{$data->date_from}}</b></td>
                </tr>  
                <tr>                    
                    <td>End Date</td>
                    <td><b>{{$data->date_to}}</b></td>
                </tr>  
                <tr> 
                    <td>Total Number of Days</td>
                    <td style=""><b>{{$data->actual_number_of_days_requested}}</b></td>
                </tr>  
                <tr> 
                    <td>Request Date</td>
                    <td><b>{{$leave_type['date']}}</b></td>
                </tr> 
                <tr> 
                    <td>Reason for Leave</td>
                    <td><b>{{$data->description}}</b></td>
                </tr>                 
            </tbody>
        </table>

        <p class="">
            Please review the request at your earliest convenience and take appropriate action. You can access the leave tracker system to approve or reject the request, or if further information is needed, please communicate directly with the employee.        </p>
        <p class="">
            Thank you for your attention to this matter. If you have any questions or require assistance, please do not hesitate to contact me.
        </p>

        <p>Best regards,</p>
        <p>Stokkafela Leave Management System</p> <br>
        <div class="p-3 rounded w-100 text-center text-light">
        Copyright © 2024 Stokka Fela (Pty) Ltd. All rights reserved
    </div>
    </div>    
</body>
</html>
