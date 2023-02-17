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
        $order=0;

        foreach($tables as $table){
            if(!in_array($table->$tableNameResolver,$ignoredTables)){
                DB::table('menus')->insert([
                    'title' => ucfirst($table->$tableNameResolver),
                    'route' => $table->$tableNameResolver.'.index',
                    'order'=> $order
                ]);
                $order++;
            }
        }
    }
}
