<?php

namespace App\Traits;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

trait UserTrait
{
    public function createdBy(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? UserModel::find($value)->name : "System"
        );
    }

    public function updatedBy(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? UserModel::find($value)->name : "System"
        );
    }

    public function deletedBy(): Attribute
    {
        return new Attribute(
            get: fn ($value) => $value ? UserModel::find($value)->name : "System"
        );
    }



    public function isDeleted()
    {
        return $this->deleted_at != null;
    }
}
