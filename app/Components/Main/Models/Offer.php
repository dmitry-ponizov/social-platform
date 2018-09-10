<?php

namespace App\Components\Main\Models;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    public function category()
    {
        return $this->belongsTo('App\Components\Main\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Components\Admin\Models\User');
    }
}
