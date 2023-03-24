<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Role;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin=Role::find(1);
        $tables = DB::select('SHOW TABLES');
        $ignoredTables=[
            "failed_jobs",
            "migrations",
            "password_resets",
            "password_reset_tokens",
            "permission_role",
            "personal_access_tokens",
            "user_roles"
        ];
        $tableNameResolver="Tables_in_".env('DB_DATABASE');

        foreach($tables as $table){
            if(!in_array($table->$tableNameResolver,$ignoredTables)){
                    Permission::generateFor($table);
                
            }
        }
        $permissions=Permission::all();
        foreach($permissions as $permission){
            $admin->permissions()->attach($permission);
        }
    }
}
