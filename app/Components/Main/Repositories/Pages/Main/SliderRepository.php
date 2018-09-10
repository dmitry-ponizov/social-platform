<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Slider;
use Session;
use Illuminate\Support\Facades\Lang;

class SliderRepository extends BaseRepository
{

    protected $model;


    public function __construct(Slider $model)
    {
        $this->model = $model;

    }

    public function storeSlider($request)
    {
        $slider = new $this->model;

        $slider->title = json_encode($request->title);

        $slider->heading = json_encode($request->heading);

        $slider->description = json_encode($request->description);

        $slider->link_title = json_encode($request->link_title);

        $image = $request->image;

        $image_new_name = time() . $image->getClientOriginalName();

        $image->move('uploads/slider', $image_new_name);

        $slider->image = 'uploads/slider/' . $image_new_name;

        $slider->order = $request->order;

        $slider->save();

        return true;

    }

    public function getSliders()
    {
        $user_permissions = $this->userPermissions();

        $fields = [

            'edit_slider' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'slider.edit',
                'button' => 'btn-dark',

            ],
            'delete_slider' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'slider.delete',
                'button' => 'btn-danger',

            ],
            'create_slider' => [
                'name' => Lang::get('main.slider.create_slider'),
                'route' => 'slider.create',
                'button' => 'btn-dark',

            ]
        ];

        $fields = array_intersect_key($fields, $user_permissions);

        $sliders = $this->model->all();

        $locale = \App::getLocale();

        $sliders_arr = [];

        foreach ($sliders as $slider) {
            $lang_title = json_decode($slider->title);
            $lang_heading = json_decode($slider->heading);
            $lang_desc = json_decode($slider->description);
            $lang_link = json_decode($slider->link_title);

            $sliders_arr[] = [
                'title' => $lang_title->$locale,
                'heading' => $lang_heading->$locale,
                'description' => $lang_desc->$locale,
                'link_title' => $lang_link->$locale,
                'image' => $slider->image,
                'order' => $slider->order,
                'id' => $slider->id,
            ];
        }


        $answer['fields'] = $fields;
        $answer['sliders'] = $sliders_arr;

        return $answer;
    }

    public function lastOrder()
    {
        $last = $this->model->orderBy('created_at', 'desc')->first();
        if (!empty($last)) {
            $last = $last->order;

            return $last + 1;
        } else {
            return 0;
        }


    }

    public function getSlider($id)
    {
        $slider = $this->model->find($id);

        $slider->title = json_decode($slider->title);

        $slider->heading = json_decode($slider->heading);

        $slider->description = json_decode($slider->description);

        $slider->link_title = json_decode($slider->link_title);

        return $slider;
    }

    public function updateSlider($id, $request)
    {

        $slider = $this->model->find($id);

        $current_image = $slider->image;

        if ($request->hasFile('image')) {

            $image = $request->image;

            $image_new_name = time() . $image->getClientOriginalName();

            $image->move('uploads/slider', $image_new_name);

            $slider->image = 'uploads/slider/' . $image_new_name;

            \File::delete('uploads/slider', $current_image);


        }

        $slider->title = json_encode($request->title);

        $slider->heading = json_encode($request->heading);

        $slider->description = json_encode($request->description);

        $slider->link_title = json_encode($request->link_title);

        $slider->order = $request->order;

        $slider->save();

        return true;
    }
}