<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class OrganizationEvent extends Model
{
    protected $casts = [
        'photo_report' => 'array'
    ];

    protected $fillable = ['body','organization_id','photo_report'];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }


}
