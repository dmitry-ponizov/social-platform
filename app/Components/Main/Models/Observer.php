<?php

namespace App\Components\Main\Models;

class Observer
{

    public function created($model)
    {
        if (auth()->id()) {
            $model->createActivityRecord('created');
        }
    }

    public function updated($model)
    {
        if (auth()->id()) {
            $model->createActivityRecord('updated');
        }
    }

    public function deleted($model)
    {
        $model->createActivityRecord('deleted');
    }


}