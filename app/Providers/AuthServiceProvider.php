<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $this->permissions();
 
    }




    public function permissions()  {
        
         Gate::define('isSuperAdmin', fn($user) => $user->hasAnyPermission(['super_admin']));
        
         Gate::define('isAdmin', fn($user) => $user->hasAnyPermission(['admin', 'super_admin']));

         Gate::define('isManager', fn($user) => $user->hasAnyPermission(['manager', 'admin', 'super_admin']));

         Gate::define('isStaff', fn($user) => $user->hasAnyPermission(['staff', 'manager', 'admin', 'super_admin']));

         Gate::define('isCustomer', fn($user) => $user->hasAnyPermission(['customer','staff', 'manager', 'admin', 'super_admin']));

    }
}
