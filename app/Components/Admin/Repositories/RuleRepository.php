<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Rule;
use App\Components\Admin\Models\User;
use App\Components\Main\Models\Category;
use Illuminate\Support\Facades\Lang;
use App\Components\Admin\Models\Group;


class RuleRepository extends BaseRepository
{

    protected $model;
    protected $user_model;
    protected $categories_model;
    protected $group_model;

    public function __construct(Rule $rule, User $user, Category $category, Group $group)
    {
        $this->model = $rule;
        $this->user_model = $user;
        $this->categories_model = $category;
        $this->group_model = $group;
    }

    public function getRules()
    {

        $user_permissions = $this->userPermissions();

        $fields = [
            'edit_categories_rule' => [
                'th_name' => Lang::get('main.rule.categories'),
                'name' => Lang::get('main.rule.view'),
                'route' => 'rule.edit.categories',
                'button' => 'btn-secondary',

            ],

            'edit_rule' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'rule.edit',
                'button' => 'btn-dark',

            ],
            'delete_rule' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'rule.delete',
                'button' => 'btn-danger',

            ]
        ];

        $fields = array_intersect_key($fields, $user_permissions);

        $rules = $this->model->with('group')->get();

        $locale = \App::getLocale();

        $result = [];
        foreach ($rules as $field => $data) {
            $lang = json_decode($data->lang);
            $group_lang = json_decode($data->group->lang);
            $result[] = [
                'id' => $data->id,
                'name' => $lang->$locale,
                'type' => Lang::get('main.rule.types.' . $data->type),
                'group' => $group_lang->$locale
            ];
        }

        $answer['fields'] = $fields;
        $answer['rules'] = $result;

        return $answer;


    }

    public function getCategories()
    {
        return $this->categories_model->all();
    }

    public function updateRule($id, $request)
    {

        $rule = parent::getById($id);

        $rule->label = $request->label;

        $rule->type = $request->type;

        $rule->group_id = $request->group;

        $rule->slug = str_slug($request->label, '_');

        $rule->lang = json_encode($request->lang);

        $rule->save();

        return 'ok';

    }

    public function getGroups()
    {
        $all_groups = $this->group_model->get();

        $locale = \App::getLocale();

        $answer = [];

        foreach ($all_groups as $group) {
            $lang = json_decode($group->lang);
            $answer[$group->id] = [
                'title' => $lang->$locale,
            ];
        }
        return $answer;
    }
}