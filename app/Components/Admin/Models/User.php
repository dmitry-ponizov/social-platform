<?php

namespace App\Components\Admin\Models;

use App\Components\Main\Models\Category;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Components\Main\Models\Activity;
use App\Components\Main\Models\Observer;
use App\Components\Main\Models\ActivityRecords;

class User extends Authenticatable
{
    use ActivityRecords;
    use  Notifiable;

    protected $triggerChangedField = ['name','surname','block','publish'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public static function boot()
    {
        self::observe(new Observer);

        parent::boot();
    }


    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users');
    }

    public function profiles()
    {
        return $this->hasMany('App\Components\Admin\Models\Profile');
    }
    public function rules()
    {
        return $this->belongsToMany(Rule::class,'profiles')->withPivot('data', 'accepted');
    }
    public function statements()
    {
        return $this->hasMany('App\Components\Main\Models\Statement');

    }

    public function offers()
    {
        return $this->hasMany('App\Components\Main\Models\Offer');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'user_category');
    }

    public function organization()
    {
        return $this->belongsTo('App\Components\Admin\Models\Organization');
    }

    public function hasAccess($data)
    {
        $rules = [];

        foreach ($this->roles as $role) {
            $rules[] = $role->hasAccess();
        }

        foreach ($this->permissions as $permission) {
            $rules[] = $permission->slug;
        }

        if (in_array($data, $rules)) {
            return true;
        }
        return false;

    }

    public function social_service()
    {
        return $this->belongsTo('App\Components\Admin\Models\SocialService');
    }



}
