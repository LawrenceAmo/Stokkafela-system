<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Type\Decimal;

class LeaveType extends Model
{
    use HasFactory;


   public function staff_leave_balances() {
        
    $leave_balances = DB::table('leave_balances')
                                ->leftJoin('users', 'users.id', '=', 'leave_balances.userID')
                                ->leftJoin('leave_types', 'leave_types.leave_typeID', '=', 'leave_balances.leave_typeID')
                                ->get();

    $userIDs = [];     $balances = [];

    for ($i=0; $i < count( $leave_balances) ; $i++) { 
        $userID = $leave_balances[$i]->userID;

        if (!in_array($userID, $userIDs, true)) {
            array_push($userIDs, $userID);
            $balances[$userID] = [];
            $balances[$userID]['userID'] = $leave_balances[$i]->userID;
            $balances[$userID]['first_name'] = $leave_balances[$i]->first_name;
            $balances[$userID]['last_name'] = $leave_balances[$i]->last_name;
            $balances[ $userID ]['total_balances'] = 0;                                            
            $balances[ $userID ]['leave_balances'] = [];                                            
        }
            $lb = [  'leave_balanceID' => $leave_balances[$i]->leave_balanceID, 'name' => $leave_balances[$i]->name, 'bal' => $leave_balances[$i]->balance,  ];
            array_push($balances[ $userID ]['leave_balances'], $lb);
            $balances[ $userID ]['total_balances'] += (float)$leave_balances[$i]->balance;                                            

    }

    return $balances;
    }
}
