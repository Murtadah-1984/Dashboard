<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordStampAndReport;
use App\Models\Role;

class Permission extends Model
{
    //use RecordStampAndReport;
    use SoftDeletes;

    protected $guarded = [];

    static $searchable = ['key','table_name'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public static function generateFor($table_name)
    {
        self::firstOrCreate(['key' => 'browse_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'read_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'edit_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'add_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'delete_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'forceDelete_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'restore_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'export_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'scope_'.$table_name, 'table_name' => $table_name]);
        self::firstOrCreate(['key' => 'stat_'.$table_name, 'table_name' => $table_name]);
    }

    public static function removeFrom($table_name)
    {
        self::where(['table_name' => $table_name])->delete();
    }
}
