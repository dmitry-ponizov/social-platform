<?php

namespace App\Components\Admin\Core;


/**
 * @property Registrar model
 */
class BaseRepository
{

    protected $model;


    public function getAll()
    {
        return $this->model->latest()->paginate(30);
    }

    public function fetchAll(){
        return $this->model->orderBy('name')->get();
    }

    public function getById($id)
    {
        return $this->model->findOrFail($id);

    }

    public function create(array $attr)
    {
        return $this->model->create($attr);
    }

    public function insert(array $attr)
    {
        return $this->model->insert($attr);
    }

    public function update($id, array $attr)
    {
        $model = $this->model->findOrFail($id);

        $model->update($attr);

        return $model;
    }

    public function delete($id)
    {
        $this->model->findOrFail($id)->delete();

        return true;
    }

    public function userPermissions()
    {
        $user = auth()->user();
        $user_permissions = [];

        foreach ($user->roles as $role) {
            if (!empty($role->permission)) {
                $user_permissions[$role->permission] = $role->permission;
            }

        }

        foreach ($user->permissions as $permission) {
            if (!empty($permission->slug)) {
                $user_permissions[$permission->slug] = $permission->slug;
            }
        }
        return $user_permissions;
    }
}