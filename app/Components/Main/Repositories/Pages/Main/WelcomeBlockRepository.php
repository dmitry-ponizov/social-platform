<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class WelcomeBlockRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateWelcome($request)
    {
        $element_col = $this->model->where('key', 'welcome_block')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $site_title = $request->site_title;

        $heading = $request->heading;

        $description = $request->description;

        $link_1 = $request->link_1;

        $link_2 = $request->link_2;

        $link_3 = $request->link_3;

        $link_4 = $request->link_4;

        $link_5 = $request->link_5;

        $link_6 = $request->link_6;

        $link_1_url = $request->link_1_url;

        $link_2_url = $request->link_2_url;

        $link_3_url = $request->link_3_url;

        $link_4_url = $request->link_4_url;

        $link_5_url = $request->link_5_url;

        $link_6_url = $request->link_6_url;

        $button_title = $request->button_title;

        $prepare = [];

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'site_title' => $site_title[$lang],
                'active' => $element['element']['main']['active'],
                'heading' => $heading[$lang],
                'description' => $description[$lang],
                'link_1' => $link_1[$lang],
                'link_2' => $link_2[$lang],
                'link_3' => $link_3[$lang],
                'link_4' => $link_4[$lang],
                'link_5' => $link_5[$lang],
                'link_6' => $link_6[$lang],
                'link_1_url' => $link_1_url,
                'link_2_url' => $link_2_url,
                'link_3_url' => $link_3_url,
                'link_4_url' => $link_4_url,
                'link_5_url' => $link_5_url,
                'link_6_url' => $link_6_url,
                'button_title' => $button_title[$lang]

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