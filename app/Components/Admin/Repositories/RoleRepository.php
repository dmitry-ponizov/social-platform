<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Role;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Permission;
use Illuminate\Support\Facades\Lang;

class RoleRepository extends BaseRepository
{

    protected $model;
    protected $user_model;
    protected $permission_model;

    public function __construct(Role $role, User $user, Permission $permission)
    {
        $this->model = $role;
        $this->user_model = $user;
        $this->permission_model = $permission;

    }

    public function saveRole($id, $request)
    {
        $role = parent::getById($id);

        $role->name = $request->name;

        $role->lang = json_encode($request->lang);

        $role->save();

        return 'ok';
    }

    public function getUsers()
    {
        return $this->user_model->all();
    }

    public function getRoles()
    {

        $user_permissions = $this->userPermissions();

        $fields = [
            'edit_role_users' => [
                'th_name' => Lang::get('main.role.users'),
                'name' => Lang::get('main.global.view'),
                'route' => 'role.edit.users',
                'button' => 'btn-secondary',

            ],
            'edit_role_permissions' => [
                'th_name' => Lang::get('main.role.permissions'),
                'name' => Lang::get('main.global.view'),
                'route' => 'role.edit.permissions',
                'button' => 'btn-secondary',

            ],
            'edit_role' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'role.edit',
                'button' => 'btn-dark',

            ],
            'delete_role' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'role.delete',
                'button' => 'btn-danger',

            ]
        ];

        $fields = array_intersect_key($fields, $user_permissions);

        $roles = $this->model->all();

        $locale = \App::getLocale();

        $result = [];
        foreach ($roles as $field => $data) {
            $lang = json_decode($data->lang);
            $result[] = [
                'id' => $data->id,
                'name' => $lang->$locale,
            ];
        }

        $answer['fields'] = $fields;
        $answer['roles'] = $result;

        return $answer;


    }

    public function getPermissions()
    {
        return $this->permission_model->all();
    }

}