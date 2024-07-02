<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accounts extends Model
{
    use HasFactory;

    protected $table = 'accounts';
    protected $primaryKey = 'accountID';

    // public function account_contacts()
    // {        
    //     return $this->belongsToMany(AccountContacts::class, 'account_contacts', 'accountID', 'account_contactID');
    // }

}
