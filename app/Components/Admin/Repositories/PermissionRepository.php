<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Permission;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Role;
use Illuminate\Support\Facades\Lang;

class PermissionRepository extends BaseRepository
{

    protected $model;
    protected $user_model;
    protected $role_model;

    public function __construct(Permission $permission, User $user, Role $role)
    {
        $this->model = $permission;
        $this->user_model = $user;
        $this->role_model = $role;

    }

    public function getPermissions()
    {
        $user_permissions = $this->userPermissions();

        $fields = [
            'edit_permission_users' => [
                'th_name' => Lang::get('main.global.users'),
                'name' => Lang::get('main.global.view'),
                'route' => 'permission.edit.users',
                'button' => 'btn-secondary',

            ],
            'edit_permission_roles' => [
                'th_name' => Lang::get('main.global.roles'),
                'name' => Lang::get('main.global.view'),
                'route' => 'permission.edit.roles',
                'button' => 'btn-secondary',

            ],
            'edit_permission' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'permission.edit',
                'button' => 'btn-dark',

            ],
            'delete_permission' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'permission.delete',
                'button' => 'btn-danger',

            ]
        ];


        $fields = array_intersect_key($fields, $user_permissions);

        $permissions = $this->model->orderBy('slug', 'DESC')->paginate(20);

        $locale = \App::getLocale();

        $result = [];

        foreach ($permissions as $field => $data) {
            $lang = json_decode($data->lang);
            $result[] = [
                'id' => $data->id,
                'lang' => $lang->$locale,
            ];
        }

        $answer['fields'] = $fields;
        $answer['permissions'] = $result;
        $answer['pages'] = $permissions;

        return $answer;
    }

    public function savePermission($id, $request)
    {
        $permission = parent::getById($id);

        $permission->label = $request->label;

        $permission->type = $request->type;

        $permission->lang = json_encode($request->lang);

        $permission->save();

        return 'ok';
    }

    public function getUsers()
    {
        return $this->user_model->all();
    }

    public function getRoles()
    {
        return $this->role_model->all();
    }


}