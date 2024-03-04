<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Models\MiniStatistics;
use App\Models\Stats;
use Illuminate\Support\Facades\Gate;

use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function user_permission($permission){
        if (!Gate::allows($permission)) {            
            return redirect()->back()->with('error', 'You are not authorized to access this function.');
        }
    }

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
 
    // 
    protected function top_products()
    {
        $stats = new Stats();
        return $stats->top_products();
    }

    // get a store from stores
    protected function get_store(Object $stores, $storeID = 0):Object
    {
        // View::share('site_settings', app('site_settings'));

        for ($i=0; $i < count($stores) ; $i++) {                 
            if ($stores[$i]->storeID == $storeID) {
                return $stores[$i];
            }
        }
        return  $stores[0];
    }


}
