<?php

namespace App\Components\Admin\Models;

use App\Components\Main\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Rule extends Model
{
    protected $fillable =['label','slug','lang','types'];

    public function categories()
    {
        return $this->belongsToMany(Category::class,'rules_categories');

    }

    public function profiles()
    {
        return $this->hasMany('App\Components\Admin\Models\Profile');
    }
    public function group()
    {
        return $this->belongsTo('App\Components\Admin\Models\Group');
    }


}
