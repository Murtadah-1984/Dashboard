<?php

namespace App\Traits;

use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use App\Models\User as UserModel;

trait User
{
    public function createdBy()
    {
        return $this->belongsTo(UserModel::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(UserModel::class, 'updated_by');
    }

    public function deletedBy()
    {
        return $this->belongsTo(UserModel::class, 'deleted_by');
    }
}