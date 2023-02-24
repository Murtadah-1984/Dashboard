<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
                DB::table('menus')->insert([
                    'title' => 'User Management',
                    'class'=>'fas fa-user-cog',
                    'order'=> 0
                ]);

                DB::table('menus')->insert([
                    'title' => 'Settings',
                    'class'=>'fas fa-cogs',
                    'order'=> 100
                ]);

                DB::table('menus')->insert([
                    'title' => 'Users',
                    'route'=>'users.index',
                    'policy'=>'browse_users',
                    'class'=>'fas fa-users',
                    'parent_id'=>1,
                    'order'=> 1
                ]);

                DB::table('menus')->insert([
                    'title' => 'Roles',
                    'route'=>'roles.index',
                    'policy'=>'browse_roles',
                    'class'=>'fas fa-user-tie',
                    'parent_id'=>1,
                    'order'=> 2
                ]);

                DB::table('menus')->insert([
                    'title' => 'Permissions',
                    'route'=>'permissions.index',
                    'policy'=>'browse_permissions',
                    'class'=>'fas fa-user-secret',
                    'parent_id'=>1,
                    'order'=> 3
                ]);

                DB::table('menus')->insert([
                    'title' => 'Menu Items',
                    'route'=>'menus.index',
                    'policy'=>'browse_menu',
                    'class'=>'fas fa-clone',
                    'parent_id'=>2,
                    'order'=> 4
                ]);

                DB::table('menus')->insert([
                    'title' => 'Dashboard Configrations',
                    'route'=>'dashboard.config',
                    'policy'=>'browse_config',
                    'class'=>'fas fa-cog',
                    'parent_id'=>2,
                    'order'=> 5
                ]);

    }
}
