<?php

namespace App\Components\Admin\Repositories;

use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\SocialService;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Role;
use Carbon\Carbon;
use App\Components\Admin\Models\Profile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;


class SocialServiceRepository extends BaseRepository
{

    protected $model;
    protected $user_model;
    protected $role_model;
    protected $profile_model;

    public function __construct(
        SocialService $social,
        User $user,
        Role $role,
        Profile $profile
    )

    {
        $this->model = $social;
        $this->user_model = $user;
        $this->role_model = $role;
        $this->profile_model = $profile;
    }

    public function getService($id)
    {
        return $this->model->with('users')->find($id);

    }

    public function createUser($attr)
    {
        $user = $this->user_model->create($attr);


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

    public function getChiefRole()
    {
        return $this->role_model->where('name', 'chief')->pluck('id');

    }

    public function saveField($request)
    {
        $user = \Auth::user();

        $field = $request->field;

        $value = $request->value;

        $social = $this->model->find($user->social_service_id);

        $social->$field = $value;

        $social->save();

        $response ['field'] = $field;

        $response ['value'] = $social->$field;

        return $response;


    }

    public function saveInfo($request)
    {
        $user = \Auth::user();

        $social = $this->model->find($user->social_service_id);

        foreach ($request->data as $key => $value) {
            $social->$key = $value;
        }

        $social->save();

        $social_service = array_filter($social->toArray(), function ($k) {
            return $k != 'id' && $k != 'created_at' && $k != 'updated_at';
        }, ARRAY_FILTER_USE_KEY);

        return $social_service;
    }

    public function workerRegistration($request)
    {

        $new_user = User::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'uuid' => Str::uuid(),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
            'types' => 'social-service',
            'social_service_id' => auth()->user()->social_service_id,
            'password' => Hash::make($request->password),
            'phone' => $request->phone
        ]);

        $new_user->roles()->sync([$request->role_id]);

        $prepare = [];

        $roles = $new_user->roles;

        $locale = \App::getLocale();

        $this->profile_model->insert([
                [
                    'user_id' => $new_user->id,
                    'rule_id' => 2,
                    'data' => $new_user->name,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
                [
                    'user_id' => $new_user->id,
                    'rule_id' => 14,
                    'data' => $new_user->phone,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
                [
                    'user_id' => $new_user->id,
                    'rule_id' => 1,
                    'data' => $new_user->surname,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
            ]
        );

        foreach ($roles as $role) {
            $lang = json_decode($role->lang);

            $prepare = [
                'id' => $new_user->id,
                'name' => $new_user->name,
                'surname' => $new_user->surname,
                'role' => $lang->$locale
            ];
        }

        return $prepare;
    }

    public function changeLogo($file)
    {
        try {
            $new_file_path = $this->moveFile($file);

            $this->model
                ->where('id', auth()->user()->social_service_id)
                ->update(['logo' => $new_file_path]);

            return $new_file_path;
        } catch (\Exception $e) {
            return false;
        }

    }

    protected function moveFile($file)
    {
        $uuid1 = Str::uuid();

        $file_name = $uuid1->toString();

        $explode = explode('.', $file->getClientOriginalName());

        $count = count($explode);

        $exp = $explode[$count - 1];

        $file_new_name = $file_name . "." . $exp;

        $file->move('uploads/social-service', $file_new_name);

        $new_file_path = $file_new_name;

        return $new_file_path;
    }
}