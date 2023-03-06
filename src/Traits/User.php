<?php

namespace App\Traits;

use App\Models\User as UserModel;
use Illuminate\Database\Eloquent\Casts\Attribute;


trait User
{
    public function createdBy(): Attribute
    {
        return new Attribute(
            get: fn ($value) => UserModel::find($value)->name
        );
    }

    public function updatedBy()
    {
        return new Attribute(
            get: fn ($value) => UserModel::find($value)->name
        );
    }

    public function deletedBy()
    {
        return new Attribute(
            get: fn ($value) => UserModel::find($value)->name
        );
    }

    public function isDeleted()
    {
        return $this->deleted_at != null;
    }
}
