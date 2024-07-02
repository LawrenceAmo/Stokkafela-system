<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountReps extends Model
{
    use HasFactory;

    protected $primaryKey = 'account_repID';

    public function account()
    {        
        return $this->belongsToMany(AccountContacts::class, 'account_contacts', 'accountID', 'account_contactID');
    }

    public function account_contacts()
    {        
        return $this->belongsToMany(AccountContacts::class, 'account_contacts', 'accountID', 'account_contactID');
    }
}
