<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\MiniStatistics;
use App\Models\Stats;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function get_mini_stats()
    {
        $stats = new MiniStatistics();
        return $stats->getMiniStatistics();        
    }

    protected function get_products_stats()
    {
        $stats = new Stats();
        return $stats->get_products_stats();        
    }

    protected function get_sales_stats()
    {
        $stats = new Stats();
        return $stats->get_sales_stats();        
    }
}
