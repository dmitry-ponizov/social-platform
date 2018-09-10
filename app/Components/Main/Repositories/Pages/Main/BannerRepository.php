<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class BannerRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }


    public function updateLeftBanner($request)
    {
        $element_col = $this->model->where('key', 'banner_main')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $heading_1 = $request->heading_1;

        $description_1 = $request->description_1;

        $heading_2 = $request->heading_2;

        $description_2 = $request->description_2;

        if ($request->hasFile('icon_1')) {

            $icon_1 = $request->icon_1;

            $icon_1_new_name = time() . $icon_1->getClientOriginalName();

            $icon_1->move('uploads/page/icons/', $icon_1_new_name);

            $icon_1 = '/uploads/page/icons/' . $icon_1_new_name;

        }

        if ($request->hasFile('icon_2')) {

            $icon_2 = $request->icon_2;

            $icon_2_new_name = time() . $icon_2->getClientOriginalName();

            $icon_2->move('uploads/page/icons/', $icon_2_new_name);

            $icon_2 = '/uploads/page/icons/' . $icon_2_new_name;

        }

        if ($request->hasFile('background')) {

            $background = $request->background;

            $background_new_name = time() . $background->getClientOriginalName();

            $background->move('uploads/page/backgrounds/', $background_new_name);

            $background = '/uploads/page/backgrounds/' . $background_new_name;

        }

        $prepare_left = [];

        foreach ($title as $lang => $value) {
            $prepare_left[$lang] = [
                'title' => $value,
                'active' => $element['element']['left']['active'],
                'background' => (isset($background)) ? $background : $element['element']['left']['background'],
                'heading_1' => $heading_1[$lang],
                'heading_2' => $heading_2[$lang],
                'icon_1' => (isset($icon_1)) ? $icon_1 : $element['element']['left']['icon_1'],
                'icon_2' => (isset($icon_2)) ? $icon_2 : $element['element']['left']['icon_2'],
                'description_1' => $description_1[$lang],
                'description_2' => $description_2[$lang]
            ];
        }


        $element['element']['left'] = $prepare_left['en'];

        $element['lang']['ru']['left'] = $prepare_left['ru'];

        $element['lang']['ua']['left'] = $prepare_left['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateRightBanner($request)
    {
        $element_col = $this->model->where('key', 'banner_main')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $description_1 = $request->description_1;

        $link_title = $request->link_title;

        $raised = $request->raised;

        $goal = $request->goal;

        if ($request->hasFile('background')) {

            $background = $request->background;

            $background_new_name = time() . $background->getClientOriginalName();

            $background->move('uploads/page/backgrounds/', $background_new_name);

            $background = '/uploads/page/backgrounds/' . $background_new_name;

        }

        $prepare_right = [];

        foreach ($title as $lang => $value) {
            $prepare_right[$lang] = [
                'title' => $value,
                'active' => $element['element']['right']['active'],
                'background' => (isset($background)) ? $background : $element['element']['right']['background'],
                'link_title' => $link_title[$lang],
                'description_1' => $description_1[$lang],
                'raised' => $raised,
                'goal' => $goal
            ];
        }

        $element['element']['right'] = $prepare_right['en'];

        $element['lang']['ru']['right'] = $prepare_right['ru'];

        $element['lang']['ua']['right'] = $prepare_right['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;

    }
}