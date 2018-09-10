<?php

namespace App\Components\Main\Models;
use App\Components\Admin\Models\Organization;
use App\Components\Admin\Models\SocialService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;


class Statement extends Model
{
    use \Laravelrus\LocalizedCarbon\Traits\LocalizedEloquentTrait;
    use Notifiable;
    use ActivityRecords;

    protected $guarded = [];

    protected $triggerChangedField = [
        'title',
        'status',
        'sum',
        'raised',
        'category_id',
        'repeat',
        'published',
        'description',
        'rate',
        'comment'
    ];

    public static function boot()
    {
        self::observe(new Observer);

        parent::boot();
    }

    public function category()
    {
        return $this->belongsTo('App\Components\Main\Models\Category');
    }

    public function user()
    {
        return $this->belongsTo('App\Components\Admin\Models\User');
    }


    public function images()
    {
        return $this->hasMany('App\Components\Main\Models\StatementImages');
    }

    public function parent()
    {
        return $this->belongsTo(Statement::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Statement::class, 'parent_id');
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function social_service()
    {
        return $this->belongsTo(SocialService::class);
    }



}
