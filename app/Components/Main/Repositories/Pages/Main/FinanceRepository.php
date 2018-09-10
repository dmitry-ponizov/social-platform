<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class FinanceRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateFinance($request)
    {
        $element_col = $this->model->where('key', 'finance')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $heading = $request->heading;

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'active' => $element['element']['wrap']['active'],
                'heading' => $heading[$lang],
            ];
        }

        $element['element']['wrap'] = $prepare['en'];

        $element['lang']['ru']['wrap'] = $prepare['ru'];

        $element['lang']['ua']['wrap'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateStatement($request)
    {
        $element_col = $this->model->where('key', 'finance')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title_1 = $request->title_1;

        $title_2 = $request->title_2;

        $title_3 = $request->title_3;

        $link_title = $request->link_title;

        $count_slides = $request->count_slides;

        foreach ($title_1 as $lang => $value) {
            $prepare[$lang] = [
                'title_1' => $value,
                'title_2' => $title_2[$lang],
                'title_3' => $title_3[$lang],
                'link_title' => $link_title[$lang],
                'active' => $element['element']['statement']['active'],
                'count_slides' => $count_slides,
            ];
        }

        $element['element']['statement'] = $prepare['en'];

        $element['lang']['ru']['statement'] = $prepare['ru'];

        $element['lang']['ua']['statement'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

}