<?php

namespace App\Components\Main\Models;


use Illuminate\Database\Eloquent\Model;
use App\Components\Admin\Models\User;

class Activity extends Model
{
    protected $guarded = [];

    public function subject()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
