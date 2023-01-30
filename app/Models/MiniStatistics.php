<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MiniStatistics extends Model
{
    use HasFactory;

    public function getMiniStatistics()
    {
        $data = [
            'staff' => DB::table('products')->sum('avrgcost'),
            'products' => DB::table('products')->count(),
            'jobs' => DB::table('jobs')->count(),
            'stores' => DB::table('stores')->count()
        ];
        return $data;
    }
}
