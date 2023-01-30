<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use PhpParser\Node\Expr\Cast\Object_;

class Store extends Model
{
    use HasFactory;

    public function create_store(Object $data)
    {

       return $data;
    }
    /*











    */
}
