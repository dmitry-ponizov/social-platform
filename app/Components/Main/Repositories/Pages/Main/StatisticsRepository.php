<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class StatisticsRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateStatistics($request, $mod)
    {
        $element_col = $this->model->where('key', 'statistics')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $sum = $request->sum;

        if ($request->hasFile('icon')) {

            $icon = $request->icon;

            $icon_new_name = time() . $icon->getClientOriginalName();

            $icon->move('uploads/defaults/icons/svg', $icon_new_name);

            $icon = $icon_new_name;

        }

        foreach ($title as $lang => $value) {
            $prepare_left[$lang] = [
                'title' => $value,
                'active' => $element['element'][$mod]['active'],
                'sum' => $sum,
                'icon' => (isset($icon)) ? $icon : $element['element'][$mod]['icon'],
            ];
        }

        $element['element'][$mod] = $prepare_left['en'];

        $element['lang']['ru'][$mod] = $prepare_left['ru'];

        $element['lang']['ua'][$mod] = $prepare_left['ua'];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }


}