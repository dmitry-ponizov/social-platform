<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class SettingsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }


    public function getPages()
    {
        $pages = $this->model->groupBy('page_slug')->pluck('page_slug');

        return $pages;
    }

    public function getElements($slug)
    {
        $elements = $this->model->where('page_slug', $slug)->pluck('key');

        return $elements;
    }

    public function getContent($slug)
    {

        $contents = $this->model->where('key', $slug)->get();

        $prepare = [];

        foreach ($contents as $content) {

            $prepare = [
                'element' => json_decode($content->element, true),
            ];


        }


        $result = [];
        foreach ($prepare['element'] as $key => $value) {

            if ($value['active'] === 'true') {
                $btn = 'btn btn-xs btn-success';
                $title = Lang::get('main.elements.hide');
                $route = 'state.hide';


            } else {
                $btn = 'btn btn-xs btn-secondary';
                $title = Lang::get('main.elements.show');
                $route = 'state.show';
            }

            $result[$key] = [
                'element' => $slug,
                'btn' => $btn,
                'title' => $title,
                'route' => $route,
                'count' => count($value)
            ];
        }


        return $result;


    }

    public function showState($elem, $mod)
    {
        $element = $this->model->where('key', $elem)->first();


        $langs = json_decode($element->lang, true);


        $new_langs = [];


        $element->element = json_decode($element->element);

        foreach ($element->element as $key => $value) {
            if ($key == $mod) {
                $value->active = 'true';
            }

        }


        foreach ($langs as $lang => $elem) {
            foreach ($elem as $key => $value) {
                if ($key == $mod) {
                    $value['active'] = 'true';
                }

                $new_langs[$lang][$key] = $value;
            }


        }

        $new_langs = json_encode($new_langs);

        $new_element = json_encode($element->element);


        $element->element = $new_element;

        $element->lang = $new_langs;

        $element->save();

        return true;

    }

    public function hideState($elem, $mod)
    {
        $element = $this->model->where('key', $elem)->first();


        $langs = json_decode($element->lang, true);

        $new_langs = [];

        $element->element = json_decode($element->element);

        foreach ($element->element as $key => $value) {
            if ($key == $mod) {
                $value->active = 'false';
            }

        }

        foreach ($langs as $lang => $elem) {
            foreach ($elem as $key => $value) {
                if ($key == $mod) {
                    $value['active'] = 'false';
                }

                $new_langs[$lang][$key] = $value;
            }

        }


        $new_langs = json_encode($new_langs);

        $new_element = json_encode($element->element);

        $element->element = $new_element;

        $element->lang = $new_langs;

        $element->save();


        return true;
    }

    public function editElement($elem, $mod)
    {

        $element = $this->model->where('key', $elem)->first();

        $element->element = json_decode($element->element);

        $element->lang = json_decode($element->lang);

        $answer = [];

        foreach ($element->lang as $key => $lang) {

            $answer[$key] = $lang->$mod;
        }

        $answer['en'] = $element->element->$mod;


        return $answer;
    }


}