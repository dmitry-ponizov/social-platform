<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class FooterRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateCompany($request)
    {
        $element_col = $this->model->where('key', 'footer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $description = $request->description;

        $link_url = $request->link_url;

        $link_title = $request->link_title;

        $facebook = $request->facebook;

        $twitter = $request->twitter;

        $skype = $request->skype;

        $google = $request->google;

        $youtube = $request->youtube;

        if ($request->hasFile('logo')) {

            $logo = $request->logo;

            $logo_new_name = time() . $logo->getClientOriginalName();

            $logo->move('uploads/page/icons', $logo_new_name);

            $logo = '/uploads/page/icons/' . $logo_new_name;

        }


        $prepare = [];

        foreach ($description as $lang => $value) {
            $prepare[$lang] = [
                'description' => $value,
                'active' => $element['element']['company']['active'],
                'logo' => (isset($logo)) ? $logo : $element['element']['company']['logo'],
                'link_url' => $link_url,
                'link_title' => $link_title[$lang],
                'facebook' => $facebook,
                'twitter' => $twitter,
                'skype' => $skype,
                'google' => $google,
                'youtube' => $youtube

            ];
        }


        $element['element']['company'] = $prepare['en'];

        $element['lang']['ru']['company'] = $prepare['ru'];

        $element['lang']['ua']['company'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateNews($request)
    {
        $element_col = $this->model->where('key', 'footer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $prepare = [];

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'active' => $element['element']['news']['active'],
            ];
        }


        $element['element']['news'] = $prepare['en'];

        $element['lang']['ru']['news'] = $prepare['ru'];

        $element['lang']['ua']['news'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateLinks($request)
    {
        $element_col = $this->model->where('key', 'footer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $link_1 = $request->link_1;

        $link_1_url = $request->link_1_url;

        $link_2 = $request->link_2;

        $link_2_url = $request->link_2_url;

        $link_3 = $request->link_3;

        $link_3_url = $request->link_3_url;

        $link_4 = $request->link_4;

        $link_4_url = $request->link_4_url;

        $link_5 = $request->link_5;

        $link_5_url = $request->link_5_url;


        $prepare = [];

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'active' => $element['element']['userful_links']['active'],
                'link_1' => $link_1[$lang],
                'link_1_url' => $link_1_url,
                'link_2' => $link_2[$lang],
                'link_2_url' => $link_2_url,
                'link_3' => $link_3[$lang],
                'link_3_url' => $link_3_url,
                'link_4' => $link_4[$lang],
                'link_4_url' => $link_4_url,
                'link_5' => $link_5[$lang],
                'link_5_url' => $link_5_url,

            ];
        }

        $element['element']['userful_links'] = $prepare['en'];

        $element['lang']['ru']['userful_links'] = $prepare['ru'];

        $element['lang']['ua']['userful_links'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateContacts($request)
    {
        $element_col = $this->model->where('key', 'footer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $phone = $request->phone;

        $email = $request->email;

        $address = $request->address;

        $prepare = [];

        foreach ($title as $lang => $value) {
            $prepare[$lang] = [
                'title' => $value,
                'active' => $element['element']['contact']['active'],
                'phone' => $phone[$lang],
                'email' => $email[$lang],
                'address' => $address[$lang],
            ];
        }

        $element['element']['contact'] = $prepare['en'];

        $element['lang']['ru']['contact'] = $prepare['ru'];

        $element['lang']['ua']['contact'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function updateBottom($request)
    {
        $element_col = $this->model->where('key', 'footer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $copyright = $request->copyright;

        $title_1 = $request->title_1;

        $link_1 = $request->link_1;

        $title_2 = $request->title_2;

        $link_2 = $request->link_2;

        $title_3 = $request->title_3;

        $link_3 = $request->link_3;

        $prepare = [];

        foreach ($copyright as $lang => $value) {
            $prepare[$lang] = [
                'copyright' => $value,
                'active' => $element['element']['bottom']['active'],
                'title_1' => $title_1[$lang],
                'link_1' => $link_1,
                'title_2' => $title_2[$lang],
                'link_2' => $link_2,
                'title_3' => $title_3[$lang],
                'link_3' => $link_3
            ];
        }

        $element['element']['bottom'] = $prepare['en'];

        $element['lang']['ru']['bottom'] = $prepare['ru'];

        $element['lang']['ua']['bottom'] = $prepare['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }
}