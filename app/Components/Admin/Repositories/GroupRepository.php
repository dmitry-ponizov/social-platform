<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Group;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Role;
use App\Components\Admin\Models\Rule;
use Illuminate\Support\Facades\Lang;

class GroupRepository extends BaseRepository
{
    protected $model;
    protected $user_model;
    protected $role_model;
    protected $rule_model;

    public function __construct(Group $group, User $user, Role $role, Rule $rule)
    {
        $this->model = $group;
        $this->user_model = $user;
        $this->role_model = $role;
        $this->rule_model = $rule;

    }

    public function getGroups()
    {
        $fields = [
            'edit_subgroups' => [
                'th_name' => Lang::get('main.rule.subgroups'),
                'name' => Lang::get('main.global.view'),
                'route' => 'subgroups',
                'button' => 'btn-secondary',

            ],
            'edit_rule' => [
                'th_name' => Lang::get('main.rule.rules'),
                'name' => Lang::get('main.global.view'),
                'route' => 'group.edit.rules',
                'button' => 'btn-secondary',

            ],
            'edit_group' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'group.edit',
                'button' => 'btn-dark',

            ],
            'delete_group' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'group.delete',
                'button' => 'btn-danger',

            ]
        ];


        $groups = $this->model->where('parent_id',0)->get();

        $locale = \App::getLocale();

        $result = [];
        foreach ($groups as $field => $data) {
            $lang = json_decode($data->lang);
            $result[] = [
                'id' => $data->id,
                'name' => $lang->$locale,
                'parent_id' => $data->parent_id
            ];
        }

        $answer['fields'] = $fields;
        $answer['groups'] = $result;

        return $answer;


    }

    public function getSubgroups($id)
    {
        $fields = [
            'edit_rule' => [
                'th_name' => Lang::get('main.rule.rules'),
                'name' => Lang::get('main.global.view'),
                'route' => 'group.edit.rules',
                'button' => 'btn-secondary',

            ],
            'edit_group' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'group.edit.subgroup',
                'button' => 'btn-dark',

            ],
            'delete_group' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'group.delete',
                'button' => 'btn-danger',

            ]
        ];

        $locale = \App::getLocale();

        $parent_group = $this->model->find($id);

        $lang = json_decode($parent_group->lang);

        $parent_group->lang = $lang->$locale;

        $subgroups = $this->model->where('parent_id', $id)->get();

        $result = [];

        foreach ($subgroups as $field => $subgroup) {
            $lang = json_decode($subgroup->lang);
            $result[] = [
                'id' => $subgroup->id,
                'title' => $lang->$locale,
            ];
        }

        $answer['fields'] = $fields;
        $answer['parent_group'] = $parent_group;
        $answer['subgroups'] = $result;

        return $answer;
    }


    public function getRules($id)
    {

        $group_rules = $this->rule_model->where('group_id', $id)->get();

        $all_groups = $this->model->get();

        $locale = \App::getLocale();

        $rules = [];

        foreach ($group_rules as $rule) {

            $lang = json_decode($rule->lang);

            $rules [$rule->id] = [
                'title' => $lang->$locale,
            ];

        }

        $groups = [];

        foreach ($all_groups as $group) {

            $lang = json_decode($group->lang);

            $groups [$group->id] = [
                'title' => $lang->$locale,
            ];
            if ($group->id == $id) {
                $groups [$group->id]['selected'] = true;
            }
        }

        $group = $this->model->find($id);

        $lang = json_decode($group->lang);

        $group->lang = $lang->$locale;


        $result = [
            'group' => $group,
            'rules' => $rules,
            'groups' => $groups,

        ];

        return $result;
    }

    public function updateRulesGroups($request)
    {

        $data = $request->except('_token');

        foreach ($data as $rule_id => $group_id) {
            $this->rule_model->where('id', $rule_id)->update(['group_id' => $group_id]);
        }

        return true;
    }


    public function updateGroup($id, $request)
    {

        $group = parent::getById($id);

        $group->label = $request->label;

        $group->slug = str_slug($request->label, '_');

        $group->lang = json_encode($request->lang);

        $group->save();

        return 'ok';

    }

    public function editSubgroup($id)
    {

        $locale = \App::getLocale();

        $subgroup = $this->model->find($id);

        $subgroup->lang = json_decode($subgroup->lang);

        $subgroup->locale = $subgroup->lang->$locale;

        $parent_groups = $this->model->where('parent_id', 0)->get();

        $result = [];

        foreach ($parent_groups as $group) {
            $lang = json_decode($group->lang);
            $result[$group->id] = [
                'title' => $lang->$locale
            ];
        }

        $answer = [
            'subgroup' => $subgroup,
            'parent_groups' => $result
        ];

        return $answer;
    }

    public function updateSubgroup($request, $id)
    {

        $subgroup = parent::getById($id);

        $subgroup->label = $request->label;

        $subgroup->slug = str_slug($request->label, '_');

        $subgroup->lang = json_encode($request->lang);

        $subgroup->parent_id = $request->parent;

        $subgroup->save();

        return 'ok';

    }

    public function getParentGroups()
    {

        $parent_groups = $this->model->where('parent_id', 0)->get();

        $locale = \App::getLocale();

        $groups = [];

        foreach ($parent_groups as $group) {

            $lang = json_decode($group->lang);

            $groups [$group->id] = [
                'title' => $lang->$locale,
            ];

        }

        return $groups;

    }

}