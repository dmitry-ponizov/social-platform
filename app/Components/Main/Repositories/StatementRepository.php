<?php

namespace App\Components\Main\Repositories;


use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Activity;
use App\Components\Main\Models\Settings;
use App\Components\Main\Models\Statement;
use App\Components\Main\Models\Category;
use App\Components\Admin\Models\User;
use App\Components\Main\Models\StatementImages;
use App\Events\StatementCreateEvent;
use App\Notifications\StatementCreate;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use App\Components\Admin\Models\Profile;
use Intervention\Image\ImageManagerStatic as Images;
use Laravelrus\LocalizedCarbon\LocalizedCarbon;
use Illuminate\Support\Str;

class StatementRepository extends BaseRepository
{

    protected $model;
    protected $category_model;
    protected $user_model;
    protected $profile_model;
    protected $images_model;
    protected $settings_model;

    public function __construct(
        Statement $model,
        Category $category,
        User $user,
        Profile $profile,
        StatementImages $images,
        Settings $settings
    )
    {
        $this->model = $model;
        $this->category_model = $category;
        $this->user_model = $user;
        $this->profile_model = $profile;
        $this->images_model = $images;
        $this->settings_model = $settings;
    }

    public function getCategories()
    {
        $categories = $this->category_model
            ->where([
            	['publish', true],
	            ['parent_id', 0 ]
            ])
	        ->with('children')
            ->select('name', 'id', 'lang')->get();

        $locale = App::getlocale();

        $result = [];

        foreach ($categories as $category) {
            $lang = json_decode($category->lang);

            $result[$category->id] = [
                'id' => $category->id,
                'name' => $category->name,
                'lang' => $lang->$locale
            ];
            foreach ($category->children as $child) {
	            $child_lang = json_decode($child->lang);
	            $result[$category->id]['children'][] = [
		            'id' => $child->id,
		            'name' => $child->name,
		            'lang' => $child_lang->$locale,
		            'publish' => $child->publish
	            ];
            }


        }
        return $result;
    }

    /**
     * @param $request
     * @return bool
     */
    public function storeStatement($request)
    {
        ($request->action == 'publish') ? $status = 'sent' : $status = 'saved';

        $statement = Statement::create([
            'uuid' => Str::uuid(),
            'category_id' => $request->category_id,
            'title' => mb_strtolower(trim(htmlspecialchars(($request->title)))),
            'repeat' => $request->repeat,
            'status' => $status,
            'parent_id' => 0,
            'days' => $request->date_time,
            'sum' => $request->sum,
            'description' => mb_strtolower(trim(htmlspecialchars(($request->description)))),
            'user_id' => \Auth::user()->id,
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()

        ]);

        $rules = [8, 9, 10, 11];

        $prepare = [
            8 => [
                'user_id' => auth()->id(),
                'rule_id' => 8,
                'data' => $request->region,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            9 => [
                'user_id' => auth()->id(),
                'rule_id' => 9,
                'data' => $request->area,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            10 => [
                'user_id' => auth()->id(),
                'rule_id' => 10,
                'data' => $request->city,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            11 => [
                'user_id' => auth()->id(),
                'rule_id' => 11,
                'data' => $request->street,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
        ];

        $profiles = $this->profile_model
            ->where('user_id', auth()->id())
            ->whereIn('rule_id', $rules)
            ->pluck('rule_id')->toArray();

        $create = [];

        $update = [];

        foreach ($rules as $rule) {
            if (in_array($rule, $profiles)) {
                $update[$rule] = $prepare[$rule];
            } else {
                $create[$rule] = $prepare[$rule];
            }
        }

        if (!empty($create)) $this->profile_model->insert($create);

        if (!empty($update))
            foreach ($update as $id => $value)
                $this->profile_model->where('user_id', auth()->id())->where('rule_id', $id)->update($value);


        $this->fileCreate($request, $statement->id);

        if ($request->repeat) $this->childrenCreateTrigger($request, $statement);

        $recipients = $this->getRecipients();

        \Notification::send($recipients, new StatementCreate($statement));

        return true;
    }


    public function getStatements()
    {
        $user_permissions = $this->userPermissions();

        $fields = [

            'view_statement' => [
                'th_name' => Lang::get('main.global.view'),
                'name' => Lang::get('main.global.detail'),
                'route' => 'statement.show',
                'button' => 'btn-secondary',


            ],
            'edit_statement' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'statement.edit',
                'button' => 'btn-dark',
                'type' => 'button',


            ],
            'delete_statement' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'statement.delete',
                'button' => 'btn-danger',


            ]
        ];


        $changed_fields = [
            'publish_statement' => [
                'th_name' => Lang::get('main.global.publish'),
                'name' => Lang::get('main.global.publish'),

            ],
            'show_user_rules' => [
                'th_name' => Lang::get('main.rule.rules'),
                'name' => Lang::get('main.global.view'),
                'route' => 'statement.rules.show',
                'button' => 'btn-secondary',


            ],

        ];

        $fields = array_intersect_key($fields, $user_permissions);

        $changed_fields = array_intersect_key($changed_fields, $user_permissions);

        $statements = $this->model
            ->where('parent_id', 0)
            ->with('category')
            ->with('user.categories')
            ->orderBy('id', "DESC")
            ->paginate(30);

        $users_ids = [];

        foreach ($statements as $statement) {
            $users_ids [] = $statement->user_id;
        }
        $users_ids = array_unique($users_ids);

        $user_categories = [];

        $users = $this->user_model->with('categories')->find($users_ids);

        foreach ($users as $user) {
            foreach ($user->categories as $category) {

                $user_categories [$user->id][] = $category->id;
            }
        }

        $local = \App::getlocale();

        $result = [];


        foreach ($statements as $field => $data) {

            if(isset($data->category->lang)){
                $lang = json_decode($data->category->lang);
                $newLang = $lang->$local;
            }else {
                $newLang = '';
            }


            $result[$data->id] = [
                'id' => $data->id,
                'category' => $newLang,
                'status' => $data->status,
                'user' => $data->user->name,
                'title' => $data->title,
            ];


            if (isset($user_categories[$data->user_id])) {
                if (in_array($data->category_id, $user_categories[$data->user_id])) {
                    if (empty($data->published)) {
                        $result[$data->id]['published'] = [
                            'route' => 'statement.publish',
                            'button' => 'btn-success',
                            'name' => Lang::get('main.statement.publish'),
                        ];

                    } else {
                        $result[$data->id]['published'] = [
                            'route' => 'statement.no.publish',
                            'button' => 'btn-danger',
                            'name' => Lang::get('main.statement.no_publish'),
                        ];
                    }
                } else {
                    $result[$data->id]['published'] = [
                        'th_name' => Lang::get('main.rule.rules'),
                        'name' => Lang::get('main.global.view'),
                        'route' => 'statement.rules.show',
                        'button' => 'btn-secondary',
                    ];
                }
            } else {
                $result[$data->id]['published'] = [
                    'th_name' => Lang::get('main.rule.rules'),
                    'name' => Lang::get('main.global.view'),
                    'route' => 'statement.rules.show',
                    'button' => 'btn-secondary',
                ];
            }


        }

        $answer['fields'] = $fields;
        $answer['statements'] = $result;
        $answer['changed_fields'] = $changed_fields;
        $answer['pages'] = $statements;

        return $answer;
    }

    public function getRelations($id)
    {
        $statement = $this->model->with('category', 'user', 'images', 'children')->find($id);

        $local = App::getlocale();

        $statement->category_title = json_decode($statement->category->lang);

        return $data = [
            'id' => $statement->id,
            'category' => $statement->category->name,
            'title' => $statement->title,
            'user' => $statement->user->name,
            'status' => $statement->status,
            'category_title' => $statement->category_title->$local,
            'description' => $statement->description,
            'region' => $statement->region,
            'area' => $statement->area,
            'city' => $statement->city,
            'street' => $statement->street,
            'repeat' => $statement->repeat,
            'published' => $statement->published,
            'created_at' => $statement->created_at->format('d.m.Y H:i'),
            'children' => $statement->children,
            'images' => $statement->images,

        ];
    }


    public function getSubstatement($id)
    {
        $statement = $this->model->with('category', 'user', 'images', 'parent')->find($id);

        $local = App::getlocale();

        $statement->category_title = json_decode($statement->category->lang);

        return $data = [
            'id' => $statement->id,
            'category' => $statement->category->name,
            'title' => $statement->title,
            'user' => $statement->user->name,
            'status' => $statement->status,
            'category_title' => $statement->category_title->$local,
            'description' => $statement->description,
            'region' => $statement->region,
            'area' => $statement->area,
            'city' => $statement->city,
            'street' => $statement->street,
            'repeat' => $statement->repeat,
            'published' => $statement->published,
            'created_at' => $statement->created_at->format('d.m.Y H:i'),
            'children' => $statement->children,
            'images' => $statement->images,

        ];
    }

    public function getUsers()
    {
        return $this->user_model->select('id', 'name')->get();
    }

    public function updateStatement($request, $id)
    {
        $statement = $this->getById($id);

        $statement->update([
            'title' => $request->title,
            'status' => $request->status,
            'category_id' => $request->category_id,
            'description' => $request->description
        ]);


        if (!empty($statement->images)) {

            foreach ($statement->images as $image) {
                if ($image->main) {
                    $current_main = $image->id;
                }
            }

            if (!empty($current_main))
                $this->images_model
                    ->where('statement_id', $id)
                    ->where('id', $current_main)
                    ->update(['main' => false]);

        }

        $this->images_model->where('statement_id', $id)->where('id', $request->main)->update(['main' => true]);

        return true;
    }


    public function published($id)
    {

        $statement = $this->model->find($id);

        $statement->published = true;

        $statement->save();

        return true;
    }

    public function noPublished($id)
    {

        $statement = $this->model->find($id);

        $statement->published = false;

        $statement->save();

        return true;
    }


    public function getRules($statement)
    {
        $category = $statement->category;

        $rules = $category->rules->toArray();

        $user = $statement->user;


        $user_rules = $user->profiles->where('accepted', true)->pluck('rule_id')->toArray();

        $locale = \App::getLocale();

        $result = [];

        foreach ($rules as $rule) {
            if (!in_array($rule['id'], $user_rules)) {
                $lang = json_decode($rule['lang'], true);
                $result[$rule['id']] = [
                    'id' => $rule['id'],
                    'type' => $rule['type'],
                    'lang' => $lang[$locale],
                ];

            }

        }

        return $result;
    }

    public function categoryRules($request)
    {

        $category = $this->category_model->find($request->category_id);

        $category_rules = $category->rules;

        $user = \Auth::user();

        $locale = \App::getLocale();

        $user_rules = $user->profiles;

        $result = [];
        $rule_user_id = [];
        foreach ($user_rules as $user_rule) {
            $rule_user_id[] = $user_rule->rule_id;
        }

        foreach ($category_rules as $rule) {
            $lang = json_decode($rule['lang'], true);
            if (!in_array($rule->id, $rule_user_id)) {
                $result[] = ['label' => $lang[$locale], 'id' => $rule->id, 'type' => $rule->type];
            }
        }

        return $result;

    }

    public function createProfiles($prepare)
    {
        $this->profile_model->insert($prepare);

        return true;
    }

    public function createSocialStatement($request)
    {
        $social_service_id = empty($request->id) ? \Auth::user()->social_service_id : $request->id;

        $statement = $this->model->create([
            'uuid' => Str::uuid(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'sum' => (!empty($request->sum)) ? $request->sum : NULL,
            'repeat' => $request->repeat,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'social_service_id' => $social_service_id,
            'days' => $request->date_time,
            'created_at' => Carbon::now(),

        ]);

        if ($request->repeat) $this->childrenSocialCreateTrigger($request, $statement);

        $this->fileCreate($request, $statement->id);

        $user = $this->user_model->with(['profiles' => function ($query) {
            $query->with('rule')->whereIn('rule_id', [5, 6]);
        }])->whereHas('statements', function ($query) use ($social_service_id) {
            $query->where('social_service_id', $social_service_id);
        })->find($request->user_id);

        $categories = $user->categories->pluck('id')->toArray();

        if (!in_array($request->category_id, $categories)) $user->categories()->attach($request->category_id);

        $result = [
            'id' => $user->id,
            'name' => $user->name,
            'surname' => $user->surname
        ];

        foreach ($user->profiles as $profile) {
            $result['rules'][$profile->rule->slug] = $profile->data;
        }
        $recipients = $this->getRecipients();

        \Notification::send($recipients, new StatementCreate($statement));

        return $result;

    }

    public function createOrganizationStatement($request)
    {
        $statement = $this->model->create([
            'uuid' => Str::uuid(),
            'category_id' => $request->category_id,
            'title' => $request->title,
            'sum' => (!empty($request->sum)) ? $request->sum : NULL,
            'repeat' => $request->repeat,
            'user_id' => $request->user_id,
            'description' => $request->description,
            'organization_id' => (empty($request->id)) ? \Auth::user()->organization_id : $request->id,
            'days' => $request->date_time,
            'created_at' => Carbon::now(),

        ]);

        $this->fileCreate($request, $statement->id);

        if ($request->repeat) $this->childrenCreateTrigger($request, $statement);

        $recipients = $this->getRecipients();

        \Notification::send($recipients, new StatementCreate($statement));

        return $statement;

    }

    public function createOrganizationSubStatement($request)
    {
        if (\Auth::user()->types == 'organization') {
            $organization_id = \Auth::user()->organization_id;
        } elseif (\Auth::user()->types == 'social-service') {
            $social_id = \Auth::user()->social_service_id;
        }


        $statement = new Statement();

        if ($request->sum != 0) {
            $statement->sum = $request->sum;
        }

        $statement->uuid = Str::uuid();
        $statement->category_id = $request->category_id;
        $statement->title = $request->title;
        $statement->repeat = $request->repeat;
        $statement->parent_id = $request->statement_id;
        $statement->status = 'sent';
        $statement->description = $request->description;
        $statement->user_id = $request->user_id;
        $statement->organization_id = (isset($organization_id)) ? $organization_id : null;
        $statement->social_service_id = (isset($social_id)) ? $social_id : null;
        $statement->created_at = Carbon::now();
        $statement->save();

        $this->fileCreate($request, $statement->id);

        $res = $this->ResponseStatement($statement);

        $recipients = $this->getRecipients();

        \Notification::send($recipients, new StatementCreate($statement));

        return $res;
    }

    public function socialUsers()
    {
        $social_id = \Auth::user()->social_service_id;

        $users = $this->user_model->with(['profiles' => function ($query) {
            $query->with('rule')->whereIn('rule_id', [5, 6]);
        }])->whereHas('statements', function ($query) use ($social_id) {
            $query->where('social_service_id', $social_id);
        })->paginate(20);


        foreach ($users as $user) {
            foreach ($user->profiles as $profile) {
                if ($profile->rule->slug === 'identification_number') {
                    $user->identification_number = $profile->data;
                } elseif ($profile->rule->slug === 'gender') {
                    $user->gender = $profile->data;
                }
            }
        }

        return $users;

    }

    public function getUserStatements($id)
    {
        $user = $this->user_model->find($id);

        $statements = $this->model
            ->where('user_id', $id)
            ->where('parent_id', 0)
            ->with('category', 'images', 'children')
            ->latest()
            ->get();

        $local = $locale = \App::getLocale();

        $res = [
            'id' => $id,
            'user' => $user->surname . " " . $user->name
        ];

        foreach ($statements as $statement) {

            $lang = json_decode($statement->category->lang);

            $res ['statements'][$statement->id] = [
                'id' => $statement->id,
                'user_id' => $statement->user_id,
                'uuid' => $statement->uuid,
                'parent_id' => $statement->parent_id,
                'title' => $statement->title,
                'category' => $lang->$local,
                'sum' => $statement->sum,
                'category_id' => $statement->category->id,
                'repeat' => $statement->repeat,
                'published' => $statement->published,
                'description' => $statement->description,
                'status' => $statement->status,
                'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
                'created_date' => $statement->created_at->format('d.m.Y'),


            ];
            foreach ($statement->images as $image) {
                $res ['statements'][$statement->id]['images'][$image->id] = $image->name;
            }

            foreach ($statement->children as $child) {
                $res ['statements'][$statement->id]['children'][$child->id] = [
                    'id' => $child->id,
                    'user_id' => $child->user_id,
                    'uuid' => $child->uuid,
                    'parent_id' => $child->parent_id,
                    'title' => $child->title,
                    'category' => $lang->$local,
                    'sum' => $child->sum,
                    'category_id' => $child->category->id,
                    'repeat' => $child->repeat,
                    'published' => $child->published,
                    'description' => $child->description,
                    'status' => $child->status,
                    'execution_date' => (isset($child->execution_date)) ? $this->executionDateFormat($child) : '',
                    'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
                    'created_date' => $statement->created_at->format('d.m.Y'),

                ];

                foreach ($child->images as $image) {
                    $res ['statements'][$statement->id]['children'][$child->id]['images'][$image->id] = $image->name;
                }
            }
        }

        return $res;
    }

    public function getChildUuid($uuid)
    {

        $statement = $this->model->where('uuid', $uuid)->with('category', 'user', 'images', 'parent')->first();


        $res = $this->prepareToResponseChild($statement);

        return $res;
    }

    public function getUuid($uuid)
    {
        $statement = $this->model->where('uuid', $uuid)->with('category', 'user', 'images', 'children')->first();

        $res = $this->prepareToResponse($statement);

        return $res;
    }

    public function fieldUpdate($request)
    {
        $field = $request->field;

        $value = $request->value;

        $id = $request->id;

        $updated_date = $request->date;

        $statement = $this->model->with('children')->find($id);

//        return [$updated_date, $statement->updated_at];
//        $this->checkDate($updated_date, $statement);

        $statement->$field = $value;

        $statement->save();

        $data = [
            'id' => $id,
            'user_id' => $statement->user_id,
            'parent_id' => $statement->parent_id,
            'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
            'field' => $field,
            'value' => $value
        ];
        return $data;
    }

    public function statusUpdate($request)
    {
        $value = $request->value;

        $id = $request->id;

        $updated_date = $request->date;

        $statement = $this->model->with('children', 'category')->find($id);

        $this->checkDate($updated_date, $statement);

        $statement->organization_id = auth()->user()->organization_id;

        $this->checkClosed($value, $statement);

        $statement->organization_id = auth()->user()->organization_id;

        $statement->status = $value;

        $statement->save();

        if ($value === 'closed' && $statement->parent_id !== 0) {
            $flag = true;
            foreach ($statement->parent->children as $child) {
                if ($child->status !== 'closed') {
                    $flag = false;
                }
            }

            if ($flag) {
                $statement->parent()->update(['status' => 'closed', 'organization_id' => auth()->user()->organization_id]);
            }


        }


        $data = [
            'id' => $id,
            'user_id' => $statement->user_id,
            'parent_id' => $statement->parent_id,
            'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
            'field' => $statement->status,
            'value' => $value
        ];

        if ($statement->category->name === 'Volunteer' && $value === 'closed') {
            User::find($statement->user_id)->update(['organization_id' => auth()->user()->organization_id]);
        }

        return $data;
    }

    public function addImage($request)
    {
        $file = $request->file('file');

        $id = $request->id;

        $count = $this->images_model->where('statement_id', $id)->count();

        if ($count >= 5) {
            abort(422, Lang::get('main.statement.messages.wrong_count'));
        }
        $statement = $this->model->find($id);

        $explode = explode('.', $file->getClientOriginalName());

        $count = count($explode);

        $exp = trim($explode[$count - 1]);

        if (($exp == 'jpeg') || ($exp == 'jpg') || ($exp == 'png') || ($exp == 'gif')) {


            $file_name = Str::uuid();

            $prepare_images = [
                'name' => $file_name . '.jpg',
                'statement_id' => $id,
                'created_at' => Carbon::now()
            ];

            Images::make($file)
                ->resize(380, 285)
                ->encode('jpg', 75)
                ->save('uploads/statements/medium/' . $file_name . '.jpg');

            Images::make($file)
                ->resize(260, 290)
                ->encode('jpg', 75)
                ->save('uploads/statements/small/' . $file_name . '.jpg');

            Images::make($file)
                ->encode('jpg', 75)
                ->save('uploads/statements/thumb/' . $file_name . '.jpg');


        } else {

            return false;
        }


        $image_id = $this->images_model->insertGetId($prepare_images);


        $response = [
            'image_id' => $image_id,
            'name' => $file_name . '.jpg',
            'id' => $statement->id,
            'parent_id' => $statement->parent_id,
            'user_id' => $statement->user_id

        ];

        return $response;
    }

    public function updateImage($request)
    {

        $image_id = $request->image_id;

        $user_id = $request->user_id;

        $file = $request->file('file');

        $image = $this->images_model->find($image_id);

        $explode = explode('.', $file->getClientOriginalName());

        $count = count($explode);

        $exp = trim($explode[$count - 1]);

        if (($exp == 'jpeg') || ($exp == 'jpg') || ($exp == 'png') || ($exp == 'gif')) {


            $file_name = Str::uuid();


            Images::make($file)
                ->resize(380, 285)
                ->encode('jpg', 75)
                ->save('uploads/statements/medium/' . $file_name . '.jpg');

            Images::make($file)
                ->resize(260, 290)
                ->encode('jpg', 75)
                ->save('uploads/statements/small/' . $file_name . '.jpg');

            Images::make($file)
                ->encode('jpg', 75)
                ->save('uploads/statements/thumb/' . $file_name . '.jpg');

            $image->name = $file_name . '.jpg';

            $image->updated_at = Carbon::now();

            $image->save();

        } else {

            return false;
        }


        $response = [
            'image_id' => $image_id,
            'name' => $file_name . '.jpg',
            'id' => $image->statement_id,
            'user_id' => $user_id

        ];

        return $response;
    }

    public function getSocialStatements()
    {
        $social_id = \Auth::user()->social_service_id;

        $statements = $this->model
            ->with('user', 'category', 'children')
            ->where('social_service_id', $social_id)
            ->where('parent_id', 0)
            ->latest()
            ->paginate(20);

        $locale = \App::getLocale();

        foreach ($statements as $statement) {

            $lang = json_decode($statement->category->lang);

            $statement->category_name = $lang->$locale;

            $statement->user_data = $statement->user->surname . " " . $statement->user->name;

        }
        return $statements;
    }


    public function noAcceptedStatements($status)
    {
        $statements = $this->model
            ->where('status', $status)
            ->where('parent_id', 0)
            ->whereHas('category', function ($query) {
                $query->where('name', '!=', 'Admin');
            })
            ->with('category', 'user', 'children')
            ->orderBy('id', 'DESC')
            ->paginate(20);


        return $statements;
    }

    public function statusStatements($status)
    {
        $statements = $this->model
            ->where('status', $status)
            ->where('parent_id', 0)
            ->where('organization_id', auth()->user()->organization_id)
            ->with('category', 'user', 'children')
            ->latest()
            ->paginate(20);


        return $statements;
    }

    public function getStatement($id)
    {

        $statement = $this->model
            ->with('category', 'user.profiles.rule', 'images', 'organization', 'social_service')
            ->where('uuid', $id)
            ->first();


        $locale = \App::getLocale();

        $category = json_decode($statement->category->lang);

        $answer = [
            'id' => $statement->id,
            'uuid' => $statement->uuid,
            'title' => $statement->title,
            'status' => $statement->status,
            'sum' => $statement->sum,
            'raised' => $statement->raised,
            'description' => $statement->description,
            'organization' => $statement->organization,
            'social_service' => $statement->social_service,
            'date' => Carbon::parse($statement->created_at)->format('Y.m.d h:i:s'),
            'category' => $category->$locale,
            'user' => $statement->user->surname . " " . $statement->user->name,
            'images' => $statement->images

        ];

        foreach ($statement->user->profiles as $profile) {
            switch ($profile->rule->slug) {
                case 'region':
                    $answer['region'] = $profile->data;
                    break;
                case 'area':
                    $answer['region'] .= ' / ' . $profile->data;
                    break;
                case 'city':
                    $answer['region'] .= ' / ' . $profile->data;
                    break;
            }

        }

        foreach ($statement->images as $image) {
            if ($image->main) {
                $answer['main_image'] = '/uploads/statements/medium/' . $image->name;
            } else {
                $answer['main_image'] = '/uploads/defaults/no_image_big.png';
            }
        }
        if (!$statement->images->count()) {
            $answer['main_image'] = '/uploads/defaults/no_image_big.png';
        }

        return $answer;


    }


    public function statements()
    {
        $statements = $this->model
            ->with('category', 'user', 'images')
            ->where('status', '!=', 'closed')
            ->where('published', 1)
            ->paginate(15);

        return $statements;
    }

    public function paginationStatements()
    {

        $statements = $this->model
            ->with('category', 'user.profiles.rule', 'images')
            ->where('status', '!=', 'closed')
            ->where('published', 1)
            ->latest()
            ->paginate(6);

        $locale = \App::getLocale();


        foreach ($statements as &$statement) {

            $statement->date = date('d.m.Y', strtotime($statement->created_at));

            foreach ($statement->user->profiles as $profile) {
                switch ($profile->rule->slug) {
                    case 'area':
                        $statement->region = $profile->data;
                        break;
                    case 'city':
                        $statement->region .= ' / ' . $profile->data;
                        break;
                }

            }

            $lang = json_decode($statement->category->lang);

            $statement->category_title = $lang->$locale;
        }


        return $statements;
    }


    public function search($search)
    {
        $search = mb_strtolower(trim(htmlspecialchars($search)));

        $sum = (int)$search;

        $statements = $this->model
            ->with('category', 'user.profiles.rule', 'images')
            ->orWhere('title', 'like', '%' . $search . '%')
            ->orWhere('description', 'like', '%' . $search . '%')
            ->orWhere('sum', $sum)->orWhere('raised', $sum)
            ->where('status', '!=', 'closed')
            ->where('published', 1)
            ->paginate(6);

        $locale = \App::getLocale();

        foreach ($statements as &$statement) {

            $statement->date = date('d.m.Y', strtotime($statement->created_at));

            foreach ($statement->user->profiles as $profile) {
                switch ($profile->rule->slug) {
                    case 'area':
                        $statement->region = $profile->data;
                        break;
                    case 'city':
                        $statement->region .= ' / ' . $profile->data;
                        break;
                }
            }

            $lang = json_decode($statement->category->lang);

            $statement->category_title = $lang->$locale;
        }

        return $statements;
    }

    public function categoriesStatements($categories)
    {

        $statements = $this->model
            ->with('category', 'user.profiles.rule', 'images')
            ->whereIn('category_id', $categories)
            ->paginate(6);

        $locale = \App::getLocale();

        foreach ($statements as &$statement) {

            $statement->date = date('d.m.Y', strtotime($statement->created_at));

            foreach ($statement->user->profiles as $profile) {
                switch ($profile->rule->slug) {
                    case 'area':
                        $statement->region = $profile->data;
                        break;
                    case 'city':
                        $statement->region .= ' / ' . $profile->data;
                        break;
                }
            }

            $lang = json_decode($statement->category->lang);

            $statement->category_title = $lang->$locale;
        }

        return $statements;
    }

    /**
     * @param $request
     * @param $statement
     */
    protected function fileCreate($request, $statement_id): void
    {
        if ($request->hasFile('file')) {

            $prepare_images = [];

            $files = $request->file('file');

            foreach ($files as $file) {

                $explode = explode('.', $file->getClientOriginalName());

                $count = count($explode);

                $exp = trim($explode[$count - 1]);

                if (($exp == 'jpeg') || ($exp == 'jpg') || ($exp == 'png') || ($exp == 'gif')) {


                    $file_name = Str::uuid();

                    $prepare_images[] = [
                        'name' => $file_name . '.jpg',
                        'statement_id' => $statement_id,
                        'created_at' => Carbon::now()
                    ];

                    Images::make($file)
                        ->resize(360, 280)
                        ->encode($exp, 75)
                        ->save('uploads/statements/medium/' . $file_name . $exp);

                    Images::make($file)
                        ->resize(260, 290)
                        ->encode($exp, 75)
                        ->save('uploads/statements/small/' . $file_name . $exp);

                    Images::make($file)
                        ->encode($exp, 75)
                        ->save('uploads/statements/thumb/' . $file_name . $exp);


                } else {
                    abort(422, 'wrong format file!');
                }

            }

            $this->images_model->insert($prepare_images);

        }
    }

    /**
     * @param $statement
     * @return array
     */
    protected function ResponseStatement($statement): array
    {
        $local = $locale = \App::getLocale();

        $lang = json_decode($statement->category->lang);

        $res = [
            'id' => $statement->id,
            'user_id' => $statement->user_id,
            'uuid' => $statement->uuid,
            'parent_id' => $statement->parent_id,
            'title' => $statement->title,
            'category' => $lang->$local,
            'sum' => $statement->sum,
            'category_id' => $statement->category->id,
            'repeat' => $statement->repeat,
            'published' => $statement->published,
            'description' => $statement->description,
            'status' => $statement->status,
            'execution_date' => (isset($statement->execution_date)) ? $this->executionDateFormat($statement) : '',
            'created_date' => $statement->created_at->format('d.m.Y'),

        ];
        foreach ($statement->images as $image) {
            $res ['images'][$image->id] = $image->name;
        }
        return $res;
    }

    /**
     * @param $user
     * @param $statements
     * @return array
     */
    protected function responseStatements($user, $id, $statements): array
    {
        $local = $locale = \App::getLocale();

        $res = [
            'id' => $id,
            'user' => $user->surname . " " . $user->name
        ];

        foreach ($statements as $statement) {

            $lang = json_decode($statement->category->lang);

            $res ['statements'][$statement->id] = [
                'id' => $statement->id,
                'user_id' => $statement->user_id,
                'uuid' => $statement->uuid,
                'parent_id' => $statement->parent_id,
                'title' => $statement->title,
                'category' => $lang->$local,
                'sum' => $statement->sum,
                'category_id' => $statement->category->id,
                'repeat' => $statement->repeat,
                'published' => $statement->published,
                'description' => $statement->description,
                'status' => $statement->status,
                'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
                'created_date' => $statement->created_at->format('d.m.Y'),


            ];
            foreach ($statement->images as $image) {
                $res ['statements'][$statement->id]['images'][$image->id] = $image->name;
            }

            foreach ($statement->children as $child) {
                $res ['statements'][$statement->id]['children'][$child->id] = [
                    'id' => $child->id,
                    'user_id' => $child->user_id,
                    'uuid' => $child->uuid,
                    'parent_id' => $child->parent_id,
                    'title' => $child->title,
                    'category' => $lang->$local,
                    'sum' => $child->sum,
                    'category_id' => $child->category->id,
                    'repeat' => $child->repeat,
                    'published' => $child->published,
                    'description' => $child->description,
                    'status' => $child->status,
                    'execution_date' => (isset($child->execution_date)) ? $this->executionDateFormat($child) : '',
                    'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
                    'created_date' => $statement->created_at->format('d.m.Y'),

                ];

                foreach ($child->images as $image) {
                    $res ['statements'][$statement->id]['children'][$child->id]['images'][$image->id] = $image->name;
                }
            }
        }
        return $res;
    }

    /**
     * @param $request
     * @param $statement
     */
    protected function childrenCreateTrigger($request, $statement): void
    {
        $date_time = json_decode($request->date_time, true);

        foreach ($date_time['days'] as $key => $day) {

            $execution_date = new Carbon("next $day");

            $execution_date->setTime($date_time['time']['HH'], $date_time['time']['mm']);

            $this->model->create([
                'uuid' => Str::uuid(),
                'category_id' => $statement->category_id,
                'title' => $statement->title . ' ' . new Carbon($execution_date),
                'repeat' => $statement->repeat,
                'status' => 'sent',
                'days' => json_encode(['day' => $day, 'time' => ['HH' => $date_time['time']['HH'], 'mm' => $date_time['time']['mm']]]),
                'parent_id' => $statement->id,
                'description' => $statement->description,
                'user_id' => $statement->user_id,
                'organization_id' => $statement->organization_id,
                'execution_date' => new Carbon($execution_date),
                'updated_at' => Carbon::now(),
                'created_at' => Carbon::now()

            ]);
        }


    }

    protected function childrenSocialCreateTrigger($request, $statement): void
    {
        $date_time = json_decode($request->date_time, true);

        foreach ($date_time['days'] as $day) {

            $execution_date = new Carbon("next $day");

            $execution_date->setTime($date_time['time']['HH'], $date_time['time']['mm']);

            $this->model->create([
                'uuid' => Str::uuid(),
                'category_id' => $statement->category_id,
                'title' => $statement->title . ' ' . new Carbon($execution_date),
                'repeat' => $statement->repeat,
                'status' => 'sent',
                'parent_id' => $statement->id,
                'description' => $statement->description,
                'user_id' => $statement->user_id,
                'social_service_id' => $statement->social_service_id,
                'execution_date' => new Carbon($execution_date),
                'created_at' => Carbon::now()

            ]);
        }


    }

    /**
     * @param $statement
     * @return string
     */
    protected function executionDateFormat($statement): string
    {
        return LocalizedCarbon::parse($statement->execution_date)
                ->format('d.m.Y H:i') . ' ( ' .
            LocalizedCarbon::parse($statement->execution_date)
                ->diffForHumans() . ' ) ';
    }

    /**
     * @param $updated_date
     * @param $statement
     */
    protected function checkDate($updated_date, $statement): void
    {
        if (strtotime($updated_date) !== strtotime($statement->updated_at)) {
            abort(422, \Lang::get('main.statement.messages.statement_changed'));
        }
    }

    /**
     * @param $value
     * @param $statement
     * @return mixed
     */
    protected function checkClosed($value, $statement)
    {
        if ($value === 'closed') {

            foreach ($statement->children as $child) {
                if ($child->status !== 'closed') {
                    abort(422, \Lang::get('main.statement.messages.no_closed'));
                }
            }
        }

    }

    /**
     * @param $value
     * @param $statement
     */
    protected function checkParentClosed($value, $statement): void
    {
        if ($value === 'closed' && $statement->parent_id !== 0) {
            $flag = true;
            foreach ($statement->parent->children as $child) {
                if ($child->status !== 'closed') {
                    $flag = false;
                }
            }

            ($flag) ?: $statement->parent()->update(['status' => 'closed']);

        }
    }

    public function history($uuid)
    {
        $statement = $this->model->where('uuid', $uuid)->first();

        $activities = Activity::where('subject_id', $statement->id)
            ->where('subject_name', 'statement')
            ->with('user')
            ->latest()
            ->with('subject')
            ->paginate(15);

        return $activities;

    }

    public function createStatement($request)
    {
        $this->model->create([
            'uuid' => Str::uuid(),
            'category_id' => 8,
            'title' => $request->title,
            'status' => 'sent',
            'description' => $request->description,
            'user_id' => auth()->id(),
            'updated_at' => Carbon::now(),
            'created_at' => Carbon::now()
        ]);

        return true;
    }

    public function getHistory()
    {
        $activities = Activity::whereHas('user', function ($query) {
            $query->where('organization_id', auth()->user()->organization_id);
        })
            ->with('user')
            ->latest()
            ->with('subject')
            ->paginate(20);

        return $activities;
    }

    public function getStatistics($time, $type)
    {

        if ($type == 'organization') {
            $field_id = 'organization_id';
            $id = auth()->user()->organization_id;
            $key1 = 'amount';
            $key2 = 'volunteers';
        } else {
            $field_id = 'social_service_id';
            $id = auth()->user()->social_service_id;
            $key1 = 'workers';
            $key2 = 'workers_count';
        }

        $activities = Activity::where('subject_name', 'statement')
            ->whereHas('user', function ($query) use ($field_id, $id) {
                $query->where($field_id, $id);
            })
            ->where('created_at', '>=', Carbon::parse($time[0])->addDay()->setTime('00', '00'))
            ->where('created_at', '<=', Carbon::parse($time[1])->addDay(2)->setTime('00', '00'))
            ->with('subject')
            ->get();


        $response = [
            'statements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ],
            'substatements' => [
                'sent' => 0,
                'accepted' => 0,
                'closed' => 0,
                'no_done' => 0
            ]
        ];
        foreach ($activities as $activity) {
            $changes = json_decode($activity->changed, true);
            foreach ($changes as $field => $change) {
                if ($field == 'status') {
                    if ($activity->subject->parent_id == 0) {
                        $response['statements'][$change] += 1;
                    } else {
                        $response['substatements'][$change] += 1;
                    }

                }
            }
            if ($activity->type === 'created') {

                if ($activity->subject->parent_id == 0) {
                    $response['statements']['sent'] += 1;
                } else {
                    $response['substatements']['sent'] += 1;
                }

            }

        }

        $response[$key1][$key2] = User::where($field_id, $id)->count();

        return $response;

    }

    public function getOrganizationStatements()
    {
        $statements = Statement::with('category', 'user', 'children')
            ->where('status', 'sent')
            ->where('parent_id', 0)
            ->where('organization_id', auth()->user()->organization_id)
            ->orderBy('id', 'DESC')
            ->paginate(20);


        return $statements;

    }

    public function changeRate($rate, $uuid, $comment)
    {
        $statement = $this->model->where('uuid', $uuid)->first();

        $statement->update(['rate' => $rate, 'comment' => $comment]);

        if ($statement->parent_id == 0) {
            return $this->prepareToResponse($statement);
        } else {
            return $this->prepareToResponseChild($statement);
        }


    }

    /**
     * @param $statement
     * @return array
     */
    protected function prepareToResponse($statement): array
    {
        $local = $locale = \App::getLocale();

        $res = [
            'id' => $statement->user->id,
            'user' => $statement->user->surname . " " . $statement->user->name
        ];

        $lang = json_decode($statement->category->lang);


        $res ['statements'][$statement->id] = [
            'id' => $statement->id,
            'user_id' => $statement->user_id,
            'user' => $statement->user->surname . " " . $statement->user->name,
            'uuid' => $statement->uuid,
            'parent_id' => $statement->parent_id,
            'title' => $statement->title,
            'category' => $lang->$local,
            'category_slug' => $statement->category->name,
            'sum' => $statement->sum,
            'category_id' => $statement->category->id,
            'repeat' => $statement->repeat,
            'published' => $statement->published,
            'rate' => $statement->rate,
            'comment' => $statement->comment,
            'description' => $statement->description,
            'status' => $statement->status,
            'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
            'created_date' => $statement->created_at->format('d.m.Y'),


        ];
        foreach ($statement->images as $image) {
            $res ['statements'][$statement->id]['images'][$image->id] = $image->name;
        }

        foreach ($statement->children as $child) {
            $res ['statements'][$statement->id]['children'][$child->id] = [
                'id' => $child->id,
                'user_id' => $child->user_id,
                'user' => $child->user->surname . " " . $child->user->name,
                'uuid' => $child->uuid,
                'parent_id' => $child->parent_id,
                'title' => $child->title,
                'category' => $lang->$local,
                'sum' => $child->sum,
                'category_id' => $child->category->id,
                'repeat' => $child->repeat,
                'published' => $child->published,
                'description' => $child->description,
                'status' => $child->status,
                'execution_date' => (isset($child->execution_date)) ? $this->executionDateFormat($child) : '',
                'updated_date' => $statement->updated_at->format('d.m.Y H:i:s'),
                'created_date' => $statement->created_at->format('d.m.Y'),

            ];

            foreach ($child->images as $image) {
                $res ['statements'][$statement->id]['children'][$child->id]['images'][$image->id] = $image->name;
            }
        }
        return $res;
    }

    /**
     * @param $statement
     * @return array
     */
    protected function prepareToResponseChild($statement): array
    {
        $local = $locale = \App::getLocale();

        $res = [
            'id' => $statement->user->id,
            'user' => $statement->user->surname . " " . $statement->user->name
        ];

        $lang = json_decode($statement->category->lang);

        $res ['statements'][$statement->parent_id] = [
            'id' => $statement->parent_id,
            'user_id' => $statement->parent->user_id,
            'user' => $statement->user->surname . " " . $statement->user->name,
            'uuid' => $statement->parent->uuid,
            'parent_id' => $statement->parent_id,
            'title' => $statement->parent->title,
            'category' => $lang->$local,
            'rate' => $statement->parent->rate,
            'comment' => $statement->parent->comment,
            'sum' => $statement->parent->sum,
            'category_id' => $statement->parent->category->id,
            'repeat' => $statement->parent->repeat,
            'published' => $statement->parent->published,
            'description' => $statement->parent->description,
            'status' => $statement->parent->status,
            'updated_date' => (isset($statement->updated_at)) ? $statement->updated_at->format('d.m.Y H:i:s') : '',
            'created_date' => $statement->created_at->format('d.m.Y'),

        ];

        $res ['statements'][$statement->parent_id]['children'][$statement->id] = [
            'id' => $statement->id,
            'user_id' => $statement->user_id,
            'uuid' => $statement->uuid,
            'user' => $statement->user->surname . " " . $statement->user->name,
            'parent_id' => $statement->parent_id,
            'title' => $statement->title,
            'category' => $lang->$local,
            'sum' => $statement->sum,
            'rate' => $statement->rate,
            'comment' => $statement->comment,
            'category_id' => $statement->category->id,
            'repeat' => $statement->repeat,
            'published' => $statement->published,
            'description' => $statement->description,
            'status' => $statement->status,
            'execution_date' => (isset($statement->execution_date)) ? $this->executionDateFormat($statement) : '',
            'updated_date' => (isset($statement->updated_at)) ? $statement->updated_at->format('d.m.Y H:i:s') : '',
            'created_date' => $statement->created_at->format('d.m.Y'),


        ];
        foreach ($statement->images as $image) {
            $res ['statements'][$statement->parent_id]['children'][$statement->id]['images'][$image->id] = $image->name;
        }
        return $res;
    }

    public function getRecipients()
    {
        return User::whereIn('types', ['volunteer', 'admin', 'social-service'])->where('id','!=',auth()->id())->get();
    }

}