<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable= [
        'label','slug','lang'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class,'user_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class,'roles_permissions');
    }
}
