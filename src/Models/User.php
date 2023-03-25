<?php

namespace App\Models;


use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\UserContract;
use App\Traits\DashboardUser;
use App\Traits\RecordStampAndReport;
use App\Traits\UserTrait;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements UserContract
{
    use DashboardUser, SoftDeletes, HasFactory, Notifiable , UserTrait, HasApiTokens;
    //use RecordStampAndReport;

    protected $guarded = [];

    static $searchable = ['name','email'];

    protected $casts = [
        'created_at' => 'datetime:d-m-Y',
        'updated_at' => 'datetime:d-m-Y',
        'deleted_at' => 'datetime:d-m-Y',
    ];

    public $additional_attributes = ['locale'];

    public function getAvatarAttribute($value)
    {
        return $value ?? config('voyager.user.default_avatar', 'users/default.png');
    }

    public function settings(): Attribute
    {
        return new Attribute(
            get: fn ($value) => collect(json_decode((string)$value)),
            set: fn ($value) => $this->attributes['settings'] = $value ? $value->toJson() : json_encode([]),
        );
    }


    public function locale(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $this->settings->get('locale'),
            set: fn ($value) => $this->settings->merge(['locale' => $value]),
        );
    }

    protected function password(): Attribute
    {
        return new Attribute(
            set: fn ($value) => Hash::make($value),
        );
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }

    public function scopeDeleted($query)
    {
        return $query->whereNotNull('deleted_at');
    }

}
