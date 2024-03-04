<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            ['permission_code' => 'super_admin', 'permission_name' => 'Super Administrator', 'priority' => 1],
            ['permission_code' => 'admin', 'permission_name' => 'Administrator', 'priority' => 2],
            ['permission_code' => 'manager', 'permission_name' => 'Manager', 'priority' => 3],
            ['permission_code' => 'staff', 'permission_name' => 'Staff', 'priority' => 4],
            ['permission_code' => 'customer', 'permission_name' => 'Customer', 'priority' => 8],
            // Add more permissions as needed
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')->insert($permission);
        }

        // run seed: php artisan db:seed --class=PermissionsTableSeeder

    }
}
