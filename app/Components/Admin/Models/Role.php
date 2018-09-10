<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable =['name'];

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users');
    }

    public function hasAccess()
    {
        foreach ($this->permissions as $permission) {

          return $permission->slug;

        }
    }

}
