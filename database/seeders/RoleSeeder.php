<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles=[
            'administrator'=>"Administrator",
            'disabled user'=>"Disabled User",
            'clark'=>"Clark",
            'manager'=>"Manager",
            'operation specialest'=>"Operation Specialest",
            'calibration engineer'=>"Calibration Engineer",
            'inspector'=>"Inspector",
            'trainer'=>"Trainer",
            'procurment specialest'=>"Procurment Specilest",
            'accountant'=>"Accountant",
            'driver'=>"Driver",
        ];

        foreach($roles as $key=>$value){
            DB::table('roles')->insert([
                'name' => $key,
                'display_name' => $value
            ]);
        }

    }
}
