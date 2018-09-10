<?php

namespace App\Components\Admin\Repositories;

use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Profile;
use App\Components\Main\Models\Settings;
use Carbon\Carbon;

class VolunteerRepository extends BaseRepository
{

    protected $model, $profile_model;


    public function __construct(User $user, Profile $profile)
    {
        $this->model = $user;
        $this->profile_model = $profile;

    }

    public function createVolunteer(array $attr)
    {
        $user = $this->model->create($attr);

        $this->profile_model->insert([
                [
                    'user_id' => $user->id,
                    'rule_id' => 2,
                    'data' => $user->name,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
                [
                    'user_id' => $user->id,
                    'rule_id' => 14,
                    'data' => $user->phone,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
                [
                    'user_id' => $user->id,
                    'rule_id' => 1,
                    'data' => $user->surname,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
            ]
        );

        return $user;
    }


    public function updateVolunteersBlock($request)
    {

        $element_col = Settings::where('key', 'volunteers')->first();

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

    public function updateCount($request)
    {
        $element_col = Settings::where('key', 'volunteers')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        $count_slides = $request->count_slides;


        $element['element']['volunteers'] = [
            'count' => $count_slides,
            'active' => $element['element']['volunteers']['active'],

        ];

        $element['lang']['ru']['volunteers'] = [
            'count' => $count_slides,
            'active' => $element['element']['volunteers']['active'],

        ];

        $element['lang']['ua']['volunteers'] = [
            'count' => $count_slides,
            'active' => $element['element']['volunteers']['active'],

        ];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;
    }

    public function becomeVolunteer($request)
    {

        $element_col = Settings::where('key', 'become_volunteer')->first();

        $element = $element_col->toArray();

        $element['element'] = json_decode($element['element'], true);

        $element['lang'] = json_decode($element['lang'], true);

        if ($request->hasFile('background')) {

            $background = $request->background;

            $background_new_name = time() . $background->getClientOriginalName();

            $background->move('uploads/page/backgrounds/', $background_new_name);

            $background = '/uploads/page/backgrounds/' . $background_new_name;

        }


        $element['element']['wrap'] = [

            'active' => $element['element']['wrap']['active'],
            'background' => (isset($background)) ? $background : $element['element']['left']['background'],
        ];

        $element['lang']['ru']['wrap'] = [

            'active' => $element['element']['wrap']['active'],
            'background' => (isset($background)) ? $background : $element['element']['left']['background'],
        ];

        $element['lang']['ua']['wrap'] = [
            'active' => $element['element']['wrap']['active'],
            'background' => (isset($background)) ? $background : $element['element']['left']['background'],
        ];

        $element_col->element = json_encode($element['element']);

        $element_col->lang = json_encode($element['lang']);

        $element_col->save();

        return true;

    }

    public function getVolunteer($uuid)
    {
        $volunteer = User::where('uuid', $uuid)->with('profiles.rule', 'organization')->first()->toArray();


        foreach ($volunteer['profiles'] as $profile) {
            $volunteer['profiles_data'][$profile['rule']['label']] = $profile['data'];
            unset($volunteer['profiles']);
        }
        return $volunteer;
    }

}