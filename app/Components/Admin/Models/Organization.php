<?php

namespace App\Components\Admin\Models;

use App\Components\Main\Models\ActivityRecords;
use App\Components\Main\Models\Statement;
use Illuminate\Database\Eloquent\Model;
use App\Components\Main\Models\Category;
use App\Components\Main\Models\Observer;

class Organization extends Model
{
    use ActivityRecords;

    protected $guarded = [];

    protected  $appends =[

        'volunteersCount'
    ];
    protected $triggerChangedField = ['name','city','street','house','office','phone','email','block','code'];


    public function statementCount()
    {
        return $this->statements->count();
    }
    public function getVolunteersCountAttribute()
    {
        return $this->users->count();
    }


    public static function boot()
    {
        self::observe(new Observer);

        parent::boot();
    }


    public function users()
    {
        return $this->hasMany('App\Components\Admin\Models\User','organization_id','id');
    }
    public function rules()
    {
        return $this->belongsToMany('App\Components\Admin\Models\Rule','rules_organizations','rule_id','org_id')->withPivot('data', 'accepted');
    }

    public function documents()
    {
        return $this->hasMany('App\Components\Admin\Models\OrganizationDocument','organization_id','id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class,'organizations_categories');
    }

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function events()
    {
        return $this->hasMany(OrganizationEvent::class);
    }

}
