<?php

namespace Murtadah\Dashboard\Facades;

use Illuminate\Support\Facades\Facade;

class Dashboard extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'dashboard';
    }
}