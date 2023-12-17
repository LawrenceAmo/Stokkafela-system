<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class StaffOrders extends Model
{
    use HasFactory;

    function generateOrderNumber($userId) {
        // Get the current timestamp
        $timestamp = now()->timestamp;
    
        // Generate a random portion (you can customize the length as needed)
        $random = Str::random(4);
    
        // Combine timestamp, user ID, and random portion to create a unique order number
        $orderNumber = $timestamp . $userId . $random;
    
        return $orderNumber;
    }


}
