<?php

namespace App\Components\Main\Repositories;

use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Facades\Lang;


class ActionsBlockRepository extends BaseRepository
{
    protected $model;

    public function __construct(Settings $model)
    {
        $this->model = $model;

    }

    public function updateActions($request, $mod)
    {
        $element_col = $this->model->where('key', 'actions_block')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $title = $request->title;

        $description = $request->description;

        $link_url = $request->link_url;

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
                'description' => $description[$lang],
                'icon' => (isset($icon)) ? $icon : $element['element'][$mod]['icon'],
                'link_url' => $link_url

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