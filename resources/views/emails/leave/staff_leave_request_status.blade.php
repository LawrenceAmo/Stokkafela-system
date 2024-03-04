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
            {{$data->first_name}} {{$data->last_name}} 
             </b>,
        </p>
        <p>This is to inform you that the status of your leave request has been updated in our leave tracker system.</p>
        <b>Leave Details:</b>

        <table class="table">
            <tbody>
                <tr>
                    <td>Leave Type</td>
                    <td><b>{{$data->name}}</b></td>
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
                    <td style=""><b>{{$data->actual_number_of_days_requested}} Days</b>  &nbsp; &nbsp;
                        @if (($data->number_of_days_requested - $data->actual_number_of_days_requested))
                            <small class="" style="color: #4d4633;">
                                Excluding {{ $data->number_of_days_requested - $data->actual_number_of_days_requested}} days OFF
                            </small>
                        @endif
                    </td>
                </tr>  
                <tr> 
                    <td>Updated Date</td>
                    <td><b>{{$data->leave_updated_at}}</b></td>
                </tr> 
                <tr> 
                    <td>New Status</td>
                    <td><b>{{$data->status}}</b></td>
                </tr> 
                <tr> 
                    <td>Updated By</td>
                    <td><b>{{$data->admin_first_name}} {{$data->admin_last_name}}</b> &nbsp; &nbsp; <small> ( <a href="mailto:{{$data->admin_email}}">{{$data->admin_email}}</a> )</small></td>
                </tr> 
                <tr> 
                    <td>Reason for update</td>
                    <td><b>{{$data->reason_to_update}}</b></td>
                </tr>    
            </tbody>
        </table>

        <p class="">
            If you have any questions or concerns regarding this status update, please feel free to reach out to the HR department for further clarification.
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
