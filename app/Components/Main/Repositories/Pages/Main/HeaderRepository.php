<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class HeaderRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateHeader($request)
    {
        $element_col = $this->model->where('key', 'header')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $phone = $request->phone;

        $email = $request->email;

        $working_hours = $request->working_hours;

        $title_1 = $request->title_1;

        $link_1 = $request->link_1;

        $title_2 = $request->title_2;

        $link_2 = $request->link_2;

        $title_3 = $request->title_3;

        $link_3 = $request->link_3;

        if ($request->hasFile('logo')) {

            $logo = $request->logo;

            $logo_new_name = time() . $logo->getClientOriginalName();

            $logo->move('uploads/page/icons', $logo_new_name);

            $logo = '/uploads/page/icons/' . $logo_new_name;

        }


        $prepare = [];

        foreach ($title_1 as $lang => $value) {
            $prepare[$lang] = [
                'title_1' => $value,
                'active' => $element['element']['main']['active'],
                'logo' => (isset($logo)) ? $logo : $element['element']['main']['logo'],
                'phone' => $phone[$lang],
                'email' => $email[$lang],
                'working_hours' => $working_hours[$lang],
                'link_1' => $link_1,
                'title_2' => $title_2[$lang],
                'link_2' => $link_2,
                'title_3' => $title_3[$lang],
                'link_3' => $link_3

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