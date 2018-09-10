<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',

    ];


    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */


    public function boot()
    {
        $this->registerPolicies();

//        Gate::resource('user', 'App\Components\Admin\Policies\UserPolicy');
//        Gate::define('user.edit.roles', 'App\Components\Admin\Policies\UserPolicy@editRoles');
//        Gate::define('user.edit.permissions', 'App\Components\Admin\Policies\UserPolicy@editPermissions');

    }


}
