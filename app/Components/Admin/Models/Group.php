<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    protected $fillable =['label','lang'];

    public function rules()
    {
        return $this->hasMany('App\Components\Admin\Models\Rule','group_id');
    }

    public function childs($id) {

        return $this->where('parent_id',$id)->pluck('slug');
    }
}
