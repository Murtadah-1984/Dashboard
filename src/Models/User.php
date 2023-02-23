<?php

namespace App\Models;

use Carbon\Carbon;
use Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Contracts\UserContract;
use App\Traits\DashboardUser;
use App\Traits\RecordStampAndReport;

class User extends Authenticatable implements UserContract
{
    use DashboardUser, RecordStampAndReport, SoftDeletes, HasFactory, Notifiable;

    protected $guarded = [];

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

    protected function title(): Attribute
    {
        return new Attribute(
            set: fn ($value) => Hash::make($value),
        );
    }

    protected static function newFactory()
    {
        return UserFactory::new();
    }
    
}
