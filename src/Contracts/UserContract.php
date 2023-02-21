<?php

namespace App\Contracts;

interface UserContract
{
    public function role();

    public function disable();

    public function setPasword($password);

    public function hasRole($name);

    public function setRole($name);

    public function hasPermission($name);

    public function hasPermissionOrFail($name);

    public function hasPermissionOrAbort($name, $statusCode = 403);
}
