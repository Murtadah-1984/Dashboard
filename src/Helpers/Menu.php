<?php

namespace App\Helpers;

use App\Models\Menu as DashboardMenu;


class Menu
{
    public static function menu()
    {
      $Menu=DashboardMenu::whereNull('parent_id')->get();
      return $Menu;
    }
}