<?php

namespace App\Components\Admin\Models;

use App\Components\Main\Models\Statement;
use Illuminate\Database\Eloquent\Model;
use App\Components\Main\Models\Observer;
use App\Components\Main\Models\ActivityRecords;


class SocialService extends Model
{
    use ActivityRecords;

    protected $guarded =[];

    protected $triggerChangedField = ['name','city','street','house','office','phone','email'];


    public static function boot()
    {
        self::observe(new Observer);

        parent::boot();
    }


    public function users()
    {
        return $this->hasMany('App\Components\Admin\Models\User','social_service_id','id');
    }

    public function statements()
    {
        return $this->hasMany(Statement::class);
    }
}
