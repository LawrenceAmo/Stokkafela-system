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
            {{$user->first_name}} {{$user->last_name}} 
        </b>,</p>
        <p>This is to confirm that your leave request has been successfully received by our leave tracker system.</p>
        <b>Leave Details:</b>

        <table class="table">
            <tbody>
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
            Our team will review your request and provide further updates accordingly. You will be notified via email once your leave request has been approved or if any additional information is required.
        </p>
        <p class="">
            Thank you for using our leave tracker system to manage your leave requests. If you have any questions or concerns, please feel free to contact the HR department.
        </p>

        <p>Best regards,</p>
        <p>Stokkafela Leave Management System</p> <br>
        <div class="p-3 rounded w-100 text-center text-light">
        Copyright © 2024 Stokka Fela (Pty) Ltd. All rights reserved
    </div>
    </div>    
</body>
</html>
