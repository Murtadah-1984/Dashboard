<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\RecordStampAndReport;
use App\Models\User;
use App\Models\Permission;


class Role extends Model
{
    use HasFactory, RecordStampAndReport, SoftDeletes;

    protected $guarded = [];

    static $searchable = ['name'];

    public function users()
    {
        $userModel = User::class;

        return $this->belongsToMany($userModel, 'user_roles')
                    ->select(app($userModel)->getTable().'.*')
                    ->union($this->hasMany($userModel))->getQuery();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    protected static function newFactory()
    {
        return RoleFactory::new();
    }
}
