<?php

namespace App\Components\Main\Models;

use App\Components\Admin\Models\Organization;
use App\Components\Admin\Models\Rule;
use Illuminate\Database\Eloquent\Model;
use App\Components\Admin\Models\User;

class Category extends Model
{
    protected $guarded = [];

    public function statements()
    {
        return $this->hasMany('App\Components\Main\Models\Statement');
    }

    public function rules()
    {
        return $this->belongsToMany(Rule::class,'rules_categories');

    }

    public function users(){
        return $this->belongsToMany(User::class,'user_category');
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class,'organizations_categories');
    }

	public function parent()
	{
		return $this->belongsTo(Category::class, 'parent_id');
	}

	public function children()
	{
		return $this->hasMany(Category::class, 'parent_id');
	}
}
