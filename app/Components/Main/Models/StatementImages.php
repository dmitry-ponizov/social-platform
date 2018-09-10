<?php

namespace App\Components\Main\Models;

use Illuminate\Database\Eloquent\Model;

class StatementImages extends Model
{

    public $table = 'statement_images';

    protected $fillable = ['name','statement_id','created_at','updated_at'];

    public function statement()
    {
        return $this->belongsTo('App\Components\Main\Models\Statement');
    }


}
