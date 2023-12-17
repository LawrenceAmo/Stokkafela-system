<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"> 
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Welcome to Stokkafela Cash & Carry</title>
    <style>
        body{
            display: flex;
            justify-content: center;
            /* background-color: #94d2ec; */
        }
        .mail-conatiner{
            /* background-color: #ebe7e8; */
            border: 1px solid rgb(42, 37, 136), 148, 44);
            border-radius: 10px;
            padding: 20px;
        }
        a{
            color: #69C0E4;
        }
        td, th{
            padding-right: 10px !important;
        }
    </style>
     
</head>
<body>
    @php
        $order_info = $order[0];
        // $items = ->toArray()
    @endphp
     <div class="mail-conatiner">
        <p class="">Hello <b class="font-weight-bold">Stokkafela Store Manager </b>,</p>
        <p>You have a new Staff order from <br>
            <b>{{ $user_info['names'] }}</b> email: <b>{{ $user_info['email'] }}</b></p>
        <p>Here is staff Order details </p>
        <table>
            <tr>
                <td>Order Number</td>
                <td>{{ $order_info->order_number }}</td>
            </tr> 
            <tr>
                <td>Ordered Items Qty</td>
                <td>{{ $order_info->total_qty }}</td>
            </tr>
            <tr>
                <td>Total Spend</td>
                <td>R{{ $order_info->total_price }}</td>
            </tr>
            <tr>
                <td>Ordered Date</td>
                <td>{{ $order_info->created_at }}</td>
            </tr>
            <tr>
                <td>Estimated Delivery Date</td>
                <td>10 - 12 - 2023</td>
            </tr>
            <tr>
                <td>Delivery for </td>
                <td>{{ $user_info['names'] }}</td>
            </tr>
        </table>
        <br> 
        <p>Ordered Items</p>
        <table class="table">
            <thead>
                <tr>
                    <th>Barcode</th>
                    <th>Description</th>
                    <th>Unit Price</th>
                    <th>Qty</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @for ($i = 0; $i < count($order); $i++)
                <tr>
                    <td>{{$order[$i]->barcode}}</td>
                    <td>{{$order[$i]->descript}}</td>
                    <td>{{$order[$i]->price}}</td>
                    <td>{{$order[$i]->qty}}</td>
                    <td>{{$order[$i]->qty * $order[$i]->price }}</td>
                     
                </tr>
                @endfor
                
            </tbody>
        </table>
        
         <p>Best regards,</p>
        <p>Stokka Fela Team</p> <br>
        <hr>
        <div class="">
            <small> Please note that this is just a notification on what a staff ordered <br>
                For more info contact staff at <b>{{ $user_info['email'] }}</b><br>
                
                 <a class="" href="mailto:info@mabebeza.com">support@stokkafela.com</a></small>
        </div> <br>
        <div class="p-3 rounded w-100 text-center text-light">
             Copyright © 2023 Stokka Fela Cash & Carry (Pty) Ltd. All rights reserved
        </div>
    </div>    
</body>
</html>
