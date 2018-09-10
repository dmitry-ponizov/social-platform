<?php

namespace App\Components\Admin\Policies;

use Illuminate\Support\Facades\Gate;
use App\Components\Admin\Models\Permission;

class AdminPolicy
{

    protected $permission;

    public function __construct(Permission $permisssion)
    {
        $this->permission = $permisssion;
    }

    public function registerAdmin()
    {


        foreach ($this->permission->all() as $value) {

            Gate::define($value->slug, function ($user) use ($value) {

                return $user->hasAccess($value->slug);

            });
        }


    }
}