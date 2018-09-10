<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class ServiceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateService($request)
    {
        $element_col = $this->model->where('key', 'service')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $heading = $request->heading;

        $count_slides = $request->count_slides;

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'active' => $element['element']['main']['active'],
                'heading' => $heading[$lang],
                'count_slides' => $count_slides
            ];
        }

        $element['element']['main'] = $prepare['en'];

        $element['lang']['ru']['main'] = $prepare['ru'];

        $element['lang']['ua']['main'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }


}