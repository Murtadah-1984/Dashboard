<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\Permission;
use App\Models\User;
use Auth;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $user =Auth::user();
        $permissions=Permission::pluck('key');
        foreach ($permissions as $permission) 
        {
            Gate::define($permission, function ($user) use ($permission) 
            {
               return $user->hasPermission($permission);
            });
        }
    }
}
