<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $fillable=[

        'user_id','rule_id','data','accepted','changed_at'
    ];

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo('App\Components\Admin\Models\User');
    }

    public function rule()
    {
        return $this->belongsTo('App\Components\Admin\Models\Rule');
    }


}
