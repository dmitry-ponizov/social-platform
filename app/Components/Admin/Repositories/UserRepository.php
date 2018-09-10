<?php

namespace App\Components\Admin\Repositories;


use App\Components\Admin\Core\BaseRepository;
use App\Components\Admin\Models\Group;
use App\Components\Admin\Models\Organization;
use App\Components\Admin\Models\User;
use App\Components\Admin\Models\Role;
use App\Components\Admin\Models\Permission;
use App\Components\Main\Models\Category;
use App\Components\Admin\Models\Rule;
use App\Components\Main\Models\Settings;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use App\Components\Admin\Models\Profile;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use App\Components\Main\Models\Activity;

class UserRepository extends BaseRepository
{

    protected $model;
    protected $role_model;
    protected $permission_model;
    protected $profile_model;
    protected $category_model;
    protected $rule_model;
    protected $group_model;
    protected $settings_model;
    protected $locale;
    protected $organization_model;

    public function __construct(
        User $user,
        Role $role,
        Permission $permission,
        Profile $profile,
        Category $category,
        Rule $rule,
        Group $group,
        Settings $settings,
        Organization $organization
    )
    {
        $this->model = $user;
        $this->role_model = $role;
        $this->permission_model = $permission;
        $this->profile_model = $profile;
        $this->category_model = $category;
        $this->rule_model = $rule;
        $this->group_model = $group;
        $this->settings_model = $settings;
        $this->locale = \App::getLocale();
        $this->organization_model = $organization;
    }


    public function allUsers()
    {
        $user_permissions = $this->userPermissions();

        $fields = [
            'block_user' => [
                'th_name' => Lang::get('main.global.blocked'),
            ],
            'show_user_detail' => [
                'th_name' => Lang::get('main.global.view'),
                'name' => Lang::get('main.global.detail'),
                'route' => 'user.show.details',
                'button' => 'btn-info',
            ],
            'edit_user_roles' => [
                'th_name' => Lang::get('main.global.roles'),
                'name' => Lang::get('main.global.view'),
                'route' => 'user.edit.roles',
                'button' => 'btn-secondary',

            ],
            'edit_user_permissions' => [
                'th_name' => Lang::get('main.global.permissions'),
                'name' => Lang::get('main.global.view'),
                'route' => 'user.edit.permissions',
                'button' => 'btn-secondary',

            ],
            'edit_user' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'user.edit',
                'button' => 'btn-dark',

            ],

            'delete_user' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'user.delete',
                'button' => 'btn-danger',

            ],

        ];


        $fields = array_intersect_key($fields, $user_permissions);


        $users = $this->model->latest()->paginate(30);

        $result = [];
        foreach ($users as $field => $data) {
            $result[$data->id] = [
                'id' => $data->id,
                'avatar' => $data->avatar,
                'name' => $data->name,
                'surname' => $data->surname,
                'phone' => $data->phone
            ];
            if (in_array('block_user', $user_permissions)) {
                $result[$data->id]['block_user'] = [
                    'th_name' => Lang::get('main.global.blocked'),
                    'name' => ($data->block) ? Lang::get('main.global.cancel') : Lang::get('main.global.block'),
                    'route' => 'user.block',
                    'button' => ($data->block) ? 'btn-primary' : 'btn-danger',
                ];
            }

        }

        $answer['fields'] = $fields;
        $answer['users'] = $result;
        $answer['data'] = $users;

        return $answer;

    }

    public function getRoles()
    {
        return $this->role_model->all();
    }

    public function getPermissions()
    {
        return $this->permission_model->all();
    }

    public function updateUser($request, $id)
    {
        $user = User::find($id);

        $current_avatar = $user->avatar;

        if ($request->hasFile('avatar')) {

            $avatar = $request->avatar;

            $avatar_new_name = time() . $avatar->getClientOriginalName();

            $avatar->move('uploads/avatars', $avatar_new_name);

            $user->avatar = 'uploads/avatars/' . $avatar_new_name;


            if ($current_avatar != "uploads/avatars/no_avatar.jpeg") {

                \File::delete('uploads/avatars/'.$current_avatar);
            }

        }

        $user->name = $request->name;

        $user->surname = $request->surname;

        if ($request->mobile_phone !== $user->phone) {
            $user->phone = $request->mobile_phone;
        }

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        return $user;
    }

    public function showUser($id)
    {
        $user = $this->model->with('rules')->find($id);

        $local = \App::getlocale();

        $rules = [];
        foreach ($user->rules as $rule) {
            $lang = json_decode($rule->lang);

            $rules[] = [
                'id' => $rule->id,
                'name' => $lang->$local,
                'type' => $rule->type,
                'data' => $rule->pivot->data,
                'accept' => $rule->pivot->accepted
            ];
        }
        sort($rules);
        $answer = [
            'user' => $user,
            'rules' => $rules
        ];

        return $answer;

    }

    public function acceptRules($request, $id)
    {

        $categories = $this->category_model->with('rules')->get();

        $category_rules = [];

        foreach ($categories as $category) {

            foreach ($category->rules as $rule) {
                $category_rules[$category->id][] = $rule->id;
            }
        }
        $category_accepted = [];

        if (!empty($request->rules)) {
            foreach ($category_rules as $category => $rule) {

                $res [$category] = array_intersect($rule, $request->rules);

                if (count($rule) == count($res[$category])) {
                    $category_accepted [] = $category;
                }

            }
        }

        $user = $this->model->find($id);

        $user->categories()->sync($category_accepted);

        $rules = $request->rules;

        $profiles = $this->profile_model->where('user_id', $id);

        $profiles->update(['accepted' => 0]);

        if (!empty($rules)) {
            $profiles->whereIn('rule_id', $rules)->update(['accepted' => 1]);
        }


        return true;

    }

    public function getUserData($user)
    {

        $locale = \App::getLocale();

        $user_data = $user->profiles->keyBy('rule_id')->toArray();

        $rules = $this->rule_model->with('group')->get();

        $groups = $this->group_model->where('parent_id', 0)->get();

        $new_groups = [];

        foreach ($groups as $group) {
            $lang = json_decode($group->lang);
            $new_groups[$group->id] = [
                'title' => $lang->$locale,
                'group_id' => $group->id,
                'slug' => $group->slug,
                'subgroup' => [],
            ];
        }


        foreach ($rules as $key => $rule) {

            $lang = json_decode($rule->lang);

            $lang_subgroup = json_decode($rule->group->lang);

            if ($rule->type == 'description') {
                $field = 'textarea';
            } elseif ($rule->type == 'file') {
                $field = 'input-file';
            } else {
                $field = 'input';
            }

            if ($rule->group->parent_id !== 0) {

                if (isset($new_groups[$rule->group->parent_id]['subgroup'][$rule->group->id])) {
                    $new_groups[$rule->group->parent_id]['subgroup'][$rule->group->id]['rules'][$rule->id] = [
                        'title' => $rule->slug,
                        'type' => $rule->type,
                        'sub_id' => $rule->group->id,
                        'field' => $field,
                        'lang' => $lang->$locale,
                        'rule_id' => $rule->id,
                    ];

                } else {
                    $new_groups[$rule->group->parent_id]['subgroup'][$rule->group->id] = [
                        'slug' => $rule->group->slug,
                        'title' => $lang_subgroup->$locale,
                        'rules' => [
                            $rule->id => [
                                'title' => $rule->slug,
                                'type' => $rule->type,
                                'sub_id' => $rule->group->id,
                                'field' => $field,
                                'lang' => $lang->$locale,
                                'rule_id' => $rule->id,
                            ]
                        ]
                    ];

                }
                if (isset($user_data[$rule->id])) {
                    $new_groups[$rule->group->parent_id]['subgroup'][$rule->group->id]['rules'][$rule->id]['user_data'] = [
                        'value' => $user_data[$rule->id]['data'],
                        'changed_at' => $user_data[$rule->id]['changed_at']
                    ];
                }
            } else {

                if (isset($new_groups[$rule->group->id]['subgroup'][$rule->group->id])) {
                    $new_groups[$rule->group->id]['subgroup'][$rule->group->id]['rules'][$rule->id] = [
                        'title' => $rule->slug,
                        'type' => $rule->type,
                        'sub_id' => $rule->group->id,
                        'field' => $field,
                        'lang' => $lang->$locale,
                        'rule_id' => $rule->id,
                    ];

                } else {
                    $new_groups[$rule->group->id]['subgroup'][$rule->group->id] = [
                        'slug' => $rule->group->slug,
                        'title' => 'other',
                        'rules' => [
                            $rule->id => [
                                'title' => $rule->slug,
                                'type' => $rule->type,
                                'sub_id' => $rule->group->id,
                                'field' => $field,
                                'lang' => $lang->$locale,
                                'rule_id' => $rule->id,
                            ]
                        ]
                    ];

                }

                if (isset($user_data[$rule->id])) {
                    $new_groups[$rule->group->id]['subgroup'][$rule->group->id]['rules'][$rule->id]['user_data'] = [
                        'value' => $user_data[$rule->id]['data'],
                        'changed_at' => $user_data[$rule->id]['changed_at']
                    ];
                }
            }

        }
        return $new_groups;
    }

    public function fieldUpdate($request)
    {

        $user = Auth::user();

        $user_id = $user->id;

        $rule_id = $request->rule_id;

        $sub_id = $request->sub_id;

        $value = $request->value;

        $locale = \App::getLocale();

        switch ($rule_id) {
            case 1:
                $user->update(['surname' => $value]);
                break;
            case 2:
                $user->update(['name' => $value]);
                break;
            case 14:
                $user->update(['phone' => $value]);
                break;
            case 16:
                $user->update(['email' => $value]);
                break;
        }

        if (!empty($request->date)) {
            $date = strtotime($request->date);

            $profile = $this->profile_model->with('rule.group')->where('rule_id', $rule_id)->where('user_id', $user_id)->first();

            $profile_date = strtotime($profile->changed_at);

            $lang = json_decode($profile->rule->lang);

            if ($date == $profile_date) {


                $profile->update([
                    'data' => $value,
                    'changed_at' => Carbon::now()
                ]);

                if ($profile->rule->type == 'description') {
                    $field = 'textarea';
                } elseif ($profile->rule->type == 'file') {
                    $field = 'input-file';
                } else {
                    $field = 'input';
                }

                $new_profile [$profile->rule->id] = [
                    'title' => $profile->rule->slug,
                    'type' => $profile->rule->type,
                    'sub_id' => $sub_id,
                    'field' => $field,
                    'lang' => $lang->$locale,
                    'rule_id' => $profile->rule->id,
                    'user_data' => [
                        'value' => $profile->data,
                        'changed_at' => strval($profile->changed_at)
                    ]
                ];
                return $new_profile;
            } else {
                return false;
            }

        } else {
            $profile = new Profile();

            $profile->user_id = $user_id;

            $profile->rule_id = $rule_id;

            $profile->data = $value;

            $profile->changed_at = Carbon::now();

            $profile->save();

            $lang = json_decode($profile->rule->lang);

            if ($profile->rule->type == 'description') {
                $field = 'textarea';
            } elseif ($profile->rule->type == 'file') {
                $field = 'input-file';
            } else {
                $field = 'input';
            }

            $new_profile [$profile->rule->id] = [
                'title' => $profile->rule->slug,
                'type' => $profile->rule->type,
                'sub_id' => $sub_id,
                'field' => $field,
                'lang' => $lang->$locale,
                'rule_id' => $profile->rule->id,
                'user_data' => [
                    'value' => $profile->data,
                    'changed_at' => strval($profile->changed_at)
                ]
            ];

            return $new_profile;
        }


    }

    public function updateFields($request)
    {
        $user_id = \Auth::id();

        $file_rule_ids = $request->file_rule_id;

        $files = $request->file('file');

        $files_dates = $request->file_date;

        $rule_ids = $request->rule_id;

        $values = $request->value;

        $dates = $request->date;

        $request_dates = [];

        $new_ids = [];

        $request_data = [];

        if (!empty($values)) {
            foreach ($dates as $key => $value) {
                if (empty($value)) {
                    $new_ids[$rule_ids[$key]] = [
                        'user_id' => $user_id,
                        'rule_id' => $rule_ids[$key],
                        'data' => $values[$key],
                        'changed_at' => Carbon::now()
                    ];
                } else {
                    $request_dates[$rule_ids[$key]] = strtotime($value);

                    $request_data [$rule_ids[$key]] = [
                        'data' => $values[$key],
                    ];
                }
            }


            if (!empty($new_ids)) {
                $this->profile_model->insert($new_ids);
            }

            if (!empty($request_data)) {

                $request_ids = array_keys($request_dates);

                $current_profiles = $this->profile_model->whereIn('rule_id', $request_ids)->where('user_id', $user_id)->get();

                $existing_dates = [];

                foreach ($current_profiles as $profile) {

                    $existing_dates[$profile->id] = strtotime($profile->changed_at);

                }

                $comparison = array_diff($request_dates, $existing_dates);


                if (!$comparison) {

                    foreach ($request_data as $id => $value) {

                        $this->profile_model->where('rule_id', $id)->where('user_id', $user_id)->update([
                            'data' => $value['data'],
                            'changed_at' => Carbon::now()
                        ]);
                    }

                } else {
                    return 'error';
                }
            }


        }


        if (!empty($files)) {

            $request_data_files = [];

            foreach ($files as $key => $file) {

                $uuid1 = Uuid::uuid1();

                $file_name = $uuid1->toString();

                $explode = explode('.', $file->getClientOriginalName());

                $count = count($explode);

                $exp = $explode[$count - 1];

                $file_new_name = $file_name . "." . $exp;

                $file->move('uploads/statements', $file_new_name);

                $request_data_files[$file_rule_ids[$key]] = [
                    'user_id' => $user_id,
                    'rule_id' => $file_rule_ids[$key],
                    'data' => '/uploads/statements/' . $file_new_name,
                    'changed_at' => $files_dates[$key]
                ];
            }

            $new_file_ids = [];

            $request_dates = [];

            foreach ($request_data_files as $rule_id => $value) {
                if (is_null($value['changed_at'])) {
                    $new_file_ids[$rule_id] = [
                        'user_id' => $user_id,
                        'rule_id' => $rule_id,
                        'data' => $value['data'],
                        'changed_at' => Carbon::now()
                    ];
                } else {
                    $request_dates[$rule_id] = strtotime($value['changed_at']);
                    $request_data [$rule_id] = [
                        'data' => $value['data'],
                    ];
                }
            }


            if (!empty($new_file_ids)) {

                $this->profile_model->insert($new_file_ids);
            }


            if (!empty($request_data)) {

                $request_ids = array_keys($request_dates);

                $current_profiles = $this->profile_model->whereIn('rule_id', $request_ids)->where('user_id', $user_id)->get();

                $existing_dates = [];

                foreach ($current_profiles as $profile) {

                    $existing_dates[$profile->id] = strtotime($profile->changed_at);

                }

                $comparison = array_diff($request_dates, $existing_dates);


                if (!$comparison) {

                    foreach ($request_data as $id => $value) {

                        $this->profile_model->where('rule_id', $id)->where('user_id', $user_id)->update([
                            'data' => $value['data'],
                            'changed_at' => Carbon::now()
                        ]);
                    }

                } else {
                    return 'error';
                }

            }
        }
        $user = Auth::user();

        $result = $this->getUserData($user);

        return $result;

    }

    public function saveFile($request)
    {
        $user_id = \Auth::id();

        $sub_id = $request->sub_id;

        $rule_id = $request->rule_id;

        $file = $request->file;

        $uuid1 = Uuid::uuid1();

        $date = strtotime($request->date);

        $locale = \App::getLocale();

        $file_name = $uuid1->toString();

        $explode = explode('.', $file->getClientOriginalName());

        $count = count($explode);

        $exp = trim($explode[$count - 1]);

        $file_new_name = $file_name . "." . $exp;

        $file->move('uploads/statements', $file_new_name);

        if (!empty($request->date)) {

            $profile = $this->profile_model->where('user_id', $user_id)->where('rule_id', $rule_id)->first();

            $current_date = strtotime($profile->changed_at);

            if ($current_date == $date) {

                $current_file = $profile->data;

                \File::delete('uploads/statements', $current_file);

                $profile->data = 'uploads/statements/' . $file_new_name;

                $profile->changed_at = Carbon::now();

                $profile->save();


            } else {
                return 'error';
            }

        } else {

            $profile = new Profile();

            $profile->user_id = $user_id;

            $profile->rule_id = $rule_id;

            $profile->data = '/uploads/statements/' . $file_new_name;

            $profile->changed_at = Carbon::now();

            $profile->save();
        }

        $lang = json_decode($profile->rule->lang);

        if ($profile->rule->type == 'description') {
            $field = 'textarea';
        } elseif ($profile->rule->type == 'file') {
            $field = 'input-file';
        } else {
            $field = 'input';
        }

        $new_profile [$profile->rule->id] = [
            'title' => $profile->rule->slug,
            'type' => $profile->rule->type,
            'sub_id' => $sub_id,
            'field' => $field,
            'lang' => $lang->$locale,
            'rule_id' => $profile->rule->id,
            'user_data' => [
                'value' => $profile->data,
                'changed_at' => strval($profile->changed_at)
            ]
        ];


        return $new_profile;
    }

    public function getAccCategories()
    {
        $user = Auth::user();

        if ($user->types == 'volunteer' && $user->organization_id) {

            $organization = $this->organization_model->find(auth()->user()->organization_id);

            $accepted_cats = $organization->categories;
        } else {
            $accepted_cats = $user->categories;
        }

        $locale = \App::getLocale();

        $result = [];

        foreach ($accepted_cats as $cat) {
            $lang = json_decode($cat->lang);

            $result[$cat->id] = [
                'id' => $cat->id,
                'title' => $lang->$locale
            ];
        }

        return (object)$result;


    }

    public function getCategories()
    {
        $categories = $this->category_model->where('publish', true)->get();

        $locale = \App::getLocale();

        $all_cat = [];

        foreach ($categories as $category) {
            $lang = json_decode($category->lang);

            $all_cat[$category->id] = [
                'id' => $category->id,
                'title' => $lang->$locale
            ];

        }

        return $all_cat;
    }

    public function checkUserCategory($request)
    {
        $category = $this->category_model->find($request->category_id);

        $locale = \App::getLocale();

        $lang_category = json_decode($category->lang);

        $category_data = [
            'id' => $category->id,
            'title' => $lang_category->$locale
        ];

        $user = Auth::user();

        $category_rules = $category->rules;

        $profiles = $user->profiles;

        $user_accepted_rules = [];

        $user_rules = [];

        foreach ($profiles as $profile) {
            $user_rules[] = $profile->rule_id;

            if ($profile->accepted) {
                $user_accepted_rules[] = $profile->rule_id;
            }
        }

        $cat_rules = [];

        foreach ($category_rules as $rule) {
            $lang = json_decode($rule->lang);
            $rule_data [$rule->id] = [
                'title' => $lang->$locale
            ];

            $cat_rules [] = $rule->id;
        }


        $no_accepted = array_diff($cat_rules, $user_accepted_rules);

        if (!empty($cat_rules)) {

            if (empty($no_accepted)) {

                $user->categories()->attach($request->category_id);

                return $category_data;

            } else {
                $parent_groups = $this->group_model->where('parent_id', 0)->get();


                $new_groups = [];

                foreach ($parent_groups as $group) {
                    $new_groups[$group->id] = [
                        'slug' => $group->slug,
                    ];
                }

                $no_data = array_diff($cat_rules, $user_rules);

                $rules = $this->rule_model->whereIn('id', $no_data)->with('group')->get();

                $new_no_data = [];

                foreach ($rules as $rule) {
                    $lang = json_decode($rule->lang);
                    $new_no_data[] = [
                        'title' => $lang->$locale,
                        'route' => '/user/' . $new_groups[$rule->group->parent_id]['slug']
                    ];

                }

                $no_accepted = array_intersect_key($rule_data, array_flip($no_accepted));

                $answer = [
                    'no_data' => $new_no_data,
                    'no_accepted' => $no_accepted,
                    'status' => 'no_data'
                ];
                return $answer;

            }
        } else {
            return 'no_rules_category';
        }


    }

    public function getRoutes($user)
    {
        $routes = [];

        switch ($user->types) {

            case 'social-service':
                if(isset($user->social_service)) {
                    list($social_service, $workers) = $this->getSocialServiceData($user, $this->locale);
                    $routes['social_service'] = [
                        'route' => 'social-service',
                        'content' => $social_service,

                    ];
                    $routes['workers'] = [
                        'route' => 'social-service-workers',
                        'content' => $workers
                    ];
                    $routes['my_statements'] = [
                        'route' => 'social-service-statements',
                        'content' => $user->statements,
                        'user_id' => $user->id
                    ];
                    $routes['statistics'] = [
                        'route' => 'social-service-statistic',
                        'content' => '',
                        'user_id' => $user->id
                    ];
                    $routes['revision_history'] = [
                        'route' => 'revision-history',
                        'content' => '',
                        'user_id' => $user->id
                    ];
                    break;
                } else {
                    break;
                }


            case 'destitute':
                $routes['my_statements'] = [
                    'route' => 'user-statements',
                    'content' => $user->statements,
                    'user_id' => $user->id
                ];
                break;

            case 'volunteer':
                if ($user->organization_id) {
                    list($organization, $documents) = $this->getOrganizationData($user, $this->locale);

                    $routes['org'] = [
                        'route' => 'organization',
                        'content' => $organization
                    ];
                    $routes['organization_documents'] = [
                        'route' => 'organization-documents',
                        'content' => (object)$documents
                    ];
                    $routes['volunteers'] = [
                        'route' => 'organization-volunteers',
                        'content' => $user->organization->users
                    ];
                    $routes['my_statements'] = [
                        'route' => 'no-accepted-statements',
                        'content' => '',
                        'user_id' => $user->id
                    ];
                    $routes['statistics'] = [
                        'route' => 'statistics',
                        'content' => '',
                        'user_id' => $user->id
                    ];
                    $routes['revision_history'] = [
                        'route' => 'revision-history',
                        'content' => '',
                        'user_id' => $user->id
                    ];
                } else {
                    $routes['my_statements'] = [
                        'route' => 'user-statements',
                        'content' => $user->statements,
                        'user_id' => $user->id
                    ];
                }
                break;
	        default:
		        $routes['my_statements'] = [
			        'route' => 'user-statements',
			        'content' => $user->statements,
			        'user_id' => $user->id
		        ];
		        break;
        }


        return $routes;

    }

    public function search($request)
    {
        $code = $request->search;

        if (!empty($code)) {

            $profile = $this->profile_model->with('user')->where('data', $code)->first();

        }

        if (empty($profile) || empty($code)) {

            return 'no_results';
        } else {
            $user = $profile->user;
            return $user;
        }

    }

    public function createUser($request)
    {

        $user = $this->model->create([
            'name' => $request->name,
            'surname' => $request->surname,
            'uuid' => Str::uuid(),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
            'types' => 'destitute',
            'social_service_id' => auth()->user()->social_service_id,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

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
                [
                    'user_id' => $user->id,
                    'rule_id' => 5,
                    'data' => $request->code,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
                [
                    'user_id' => $user->id,
                    'rule_id' => 6,
                    'data' => $request->gender,
                    'accepted' => false,
                    'changed_at' => Carbon::now()
                ],
            ]
        );

        return true;
    }

    public function getLang()
    {
        $messages = Lang::get('main.user');

        $messages['social'] = Lang::get('main.social_service');

        $messages['organization'] = Lang::get('main.organization');

        $messages['registration'] = Lang::get('main.main.registration');

        $messages['statement'] = Lang::get('main.statement');

        $messages['main'] = Lang::get('main.main');


        return $messages;
    }

    public function updateProfiles($user, $request)
    {

        $rules = Rule::whereIn('slug', ['name', 'surname', 'mobile_phone', 'identification_number'])
            ->pluck('id', 'slug');

        $user->rules()->detach($rules);

        $prepare_to_create = [];

        foreach ($rules as $name => $id) {
            $prepare_to_create[$id] = [
                'data' => $request->$name,
                'changed_at' => Carbon::now()
            ];
        }

        $user->rules()->attach($prepare_to_create);

        return true;
    }

    public function saveProfiles($user, $request)
    {
        $rules = Rule::whereIn('slug', ['name', 'surname', 'mobile_phone', 'identification_number'])
            ->pluck('id', 'slug');

        $prepare_to_create = [];

        foreach ($rules as $name => $id) {
            $prepare_to_create[$id] = [
                'data' => !$name == 'mobile_phone' ? $request->$name : $request->phone,
                'changed_at' => Carbon::now()
            ];
        }

        $user->rules()->attach($prepare_to_create);

        return true;
    }

    /**
     * @param $user
     * @param $locale
     * @return array
     */
    protected function getOrganizationData($user, $locale): array
    {
        $organization = array_filter($user->organization->toArray(), function ($k) {
            return $k != 'id' && $k != 'volunteersCount' && $k != 'created_at' && $k != 'slug' && $k != 'updated_at' && $k != 'users' && $k != 'block';
        }, ARRAY_FILTER_USE_KEY);


        $docs = $user->organization->documents;

        $documents = [];

        foreach ($docs as $document) {
            $documents[$document->name][$document->id] = [
                'id' => $document->id,
                'type' => $document->type,
                'name' => $document->name,
                'data' => $document->data,
                'organization_id' => $document->organization_id,

            ];
        }

        return array($organization, $documents);
    }

    /**
     * @param $user
     * @param $locale
     * @return array
     */
    protected function getSocialServiceData($user, $locale)
    {
            $social_service = array_filter($user->social_service->toArray(), function ($k) {
                return $k != 'id' && $k != 'created_at' && $k != 'updated_at' && $k != 'users';
            }, ARRAY_FILTER_USE_KEY);

            $workers = [];


            foreach ($user->social_service->users as $new_user) {
                $workers [$new_user->id] = [
                    'name' => $new_user->name,
                    'surname' => $new_user->surname,
                ];
                foreach ($new_user->roles as $role) {
                    $lang = json_decode($role->lang);
                    $workers[$new_user->id]['role'] = $lang->$locale;
                }

            }
            return array($social_service, $workers);


    }

    public function userBlock($id)
    {
        $user = $this->model->find($id);

        $user->update(['block' => !$user->block]);

        return true;
    }

    public function volunteers()
    {
        return $this->model->where('types', 'volunteer')->paginate(20);
    }

    public function userPublish($id)
    {
        $user = $this->model->find($id);

        $user->update(['publish' => !$user->publish]);

        return true;
    }

    public function addProfile($user_id, $code)
    {
        $rule = Rule::select('id')->where('label', 'Identification number')->first();

        Profile::create([
            'user_id' => $user_id,
            'rule_id' => $rule->id,
            'data' => $code,
            'changed_at' => Carbon::now()
        ]);

        return true;

    }

    public function getUser($id)
    {
        return $this->model->with(['profiles' => function ($query) {
            $query->whereHas('rule', function ($query) {
                $query->where('slug', 'identification_number');
            });
        }])->findOrFail($id);
    }
}
