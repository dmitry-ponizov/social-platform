<?php

namespace App\Components\Admin\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Components\Admin\Models\User;

class UserPolicy
{

    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
    public function view(User $user)
    {
        return $user->hasAccess('view_user');
    }


    public function create(User $user)
    {
        return $user->hasAccess('create_user');
    }

    public function update(User $user)
    {
        return $user->hasAccess('update_user');
    }

    public function delete(User $user)
    {
        return $user->hasAccess('delete_user');
    }

    public function editRoles(User $user)
    {
        return $user->hasAccess('edit_roles');
    }

    public function editPermissions(User $user)
    {
        return $user->hasAccess('edit_permissions');
    }
}