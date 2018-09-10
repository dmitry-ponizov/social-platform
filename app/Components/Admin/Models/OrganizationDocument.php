<?php

namespace App\Components\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use App\Components\Main\Models\ActivityRecords;
use App\Components\Main\Models\Observer;

class OrganizationDocument extends Model
{
    use ActivityRecords;

    protected $guarded = [];

    protected $table = 'organization_documents';

    protected $triggerChangedField = ['name', 'data'];

    public static function boot()
    {
        self::observe(new Observer);

        parent::boot();
    }

    public function organization()
    {
        return $this->belongsTo('App\Components\Admin\Models\Organization');
    }
}
