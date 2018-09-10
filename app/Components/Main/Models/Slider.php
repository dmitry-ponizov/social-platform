<?php

namespace App\Components\Main\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $fillable =[
        'title','heading','description','image','order'
    ];
}
