<?php

namespace App\Components\Main\Core;

use App\Components\Main\Models\Settings;


/**
 * @property Registrar model
 */
class BaseRepository
{

    protected $model;


    public function getAll()
    {
        return $this->model->get();
    }


    public function getById($id)
    {
        $model = $this->model->findOrFail($id);
        return $model;
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

    public static function getSettings()
    {
        $settings = Settings::all();

        $locale = \App::getLocale();

        $result = [];

        foreach ($settings as $setting){
            if($locale =='en'){

                $result[$setting->key] = [
                    'element' => json_decode($setting->element),

                ];
            }else{
                $lang = json_decode($setting->lang);

                $result[$setting->key] = [
                    'element'=>$lang->$locale,

                ];
            }
        }
        $result['banner_main']['lang'] = \Lang::get('main.main');

        return $result;
    }
}