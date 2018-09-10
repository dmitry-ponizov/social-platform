<?php

namespace App\Components\Main\Repositories;

use App\Components\Admin\Models\Profile;
use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Offer;
use App\Components\Main\Models\Settings;
use App\Components\Main\Models\Category;
use App\Components\Admin\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Carbon\Carbon;

class OfferRepository extends BaseRepository
{
    protected $model;
    protected $category_model;
    protected $user_model;
    protected $settings_model;
    protected $profile_model;

    public function __construct(
        Offer $model,
        Category $category,
        User $user,
        Settings $settings,
        Profile $profile
    )
    {
        $this->model = $model;
        $this->category_model = $category;
        $this->user_model = $user;
        $this->settings_model = $settings;
        $this->profile_model = $profile;
    }


    public function getCategories()
    {
        $categories = $this->category_model->select('name', 'id', 'lang')->get();

        $local = App::getlocale();

        foreach ($categories as $category) {
            $lang = json_decode($category->lang);

            $category->lang = $lang->$local;
        }
        return $categories;
    }

    public function storeOffer($request)
    {

        $this->model->insertGetId([
            'title' => mb_strtolower(trim(htmlspecialchars(($request->title)))),
            'repeat' => $request->repeat,
            'status' => 'sent',
            'days' => $request->date_time,
            'description' => mb_strtolower(trim(htmlspecialchars(($request->description)))),
            'user_id' => \Auth::user()->id,
            'created_at' => Carbon::now()
        ]);


        $user = \Auth::user();

        $rules = [8, 9, 10, 11];

        $prepare = [
            8 => [
                'user_id' => $user->id,
                'rule_id' => 8,
                'data' => $request->region,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            9 => [
                'user_id' => $user->id,
                'rule_id' => 9,
                'data' => $request->area,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            10 => [
                'user_id' => $user->id,
                'rule_id' => 10,
                'data' => $request->city,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
            11 => [
                'user_id' => $user->id,
                'rule_id' => 11,
                'data' => $request->street,
                'accepted' => false,
                'changed_at' => Carbon::now()
            ],
        ];

        $profiles = $this->profile_model->where('user_id', $user->id)->whereIn('rule_id', $rules)->pluck('rule_id')->toArray();


        $create = [];

        $update = [];

        foreach ($rules as $rule) {
            if (in_array($rule, $profiles)) {
                $update[$rule] = $prepare[$rule];
            } else {
                $create[$rule] = $prepare[$rule];
            }
        }

        if (!empty($create)) {
            $this->profile_model->insert($create);
        }

        if (!empty($update)) {
            foreach ($update as $id => $value) {
                $this->profile_model->where('user_id', $user->id)->where('rule_id', $id)->update($value);
            }
        }

        return true;
    }

    public function getOffers()
    {
        $user_permissions = $this->userPermissions();

        $fields = [


            'view_offer' => [
                'th_name' => Lang::get('main.global.view'),
                'name' => Lang::get('main.global.detail'),
                'route' => 'offer.show',
                'button' => 'btn-secondary',
                'changed' => false

            ],

            'edit_offer' => [
                'th_name' => Lang::get('main.global.edit'),
                'name' => Lang::get('main.global.edit'),
                'route' => 'offer.edit',
                'button' => 'btn-dark',
                'changed' => false

            ],
            'delete_offer' => [
                'th_name' => Lang::get('main.global.delete'),
                'name' => Lang::get('main.global.delete'),
                'route' => 'offer.delete',
                'button' => 'btn-danger',
                'changed' => false

            ]
        ];


        $changed_fields = [
            'publish_offer' => [
                'th_name' => Lang::get('main.global.publish'),
                'name' => Lang::get('main.global.publish'),
                'changed' => true
            ],
            'accept_offer' => [
                'th_name' => Lang::get('main.global.accept'),
                'name' => Lang::get('main.global.accept'),
                'changed' => true


            ],
            'close_offer' => [
                'th_name' => Lang::get('main.global.close'),
                'name' => Lang::get('main.global.close'),
                'changed' => true

            ],
        ];
        $fields = array_intersect_key($fields, $user_permissions);

        $changed_fields = array_intersect_key($changed_fields, $user_permissions);

        $offers = $this->model->with('category', 'user')->orderBy('title')->get();

        $local = \App::getlocale();

        $result = [];


        foreach ($offers as $field => $data) {

            $result[$data->id] = [
                'id' => $data->id,

                'user' => $data->user->name,
                'title' => $data->title,
            ];
            if (isset($changed_fields['publish_offer'])) {
                if (empty($data->published)) {
                    $result[$data->id]['fields']['published'] = [
                        'route' => 'offer.publish',
                        'icon' => 'fa fa-eye-slash'
                    ];

                } else {
                    $result[$data->id]['fields']['published'] = [
                        'route' => 'offer.no.publish',
                        'icon' => 'fa fa-eye'
                    ];
                }
            }
            if (isset($changed_fields['accept_offer'])) {
                if (empty($data->accept_date)) {
                    $result[$data->id]['fields']['accepted'] = [
                        'route' => 'offer.accept',
                        'icon' => 'fa fa-times'
                    ];

                } else {
                    $result[$data->id]['fields']['accepted'] = [
                        'route' => 'offer.accept',
                        'icon' => 'fa fa-check'
                    ];
                }
            }
            if (isset($changed_fields['close_offer'])) {
                if (empty($data->close_date)) {
                    $result[$data->id]['fields']['closed'] = [
                        'route' => 'offer.close',
                        'icon' => 'fa fa-times'
                    ];
                } else {
                    $result[$data->id]['fields']['closed'] = [
                        'route' => 'offer.close',
                        'icon' => 'fa fa-check'
                    ];
                }
            }

        }

        $answer['fields'] = $fields;
        $answer['changed_fields'] = $changed_fields;
        $answer['offers'] = $result;
//        dd($answer);
        return $answer;
    }

    public function getRelations($id)
    {
        $offer = $this->model->with('category', 'user')->find($id);

        $local = App::getlocale();

        return $data = [
            'id' => $offer->id,
            'title' => $offer->title,
            'user' => $offer->user->name,
            'description' => $offer->description,
            'region' => $offer->region,
            'area' => $offer->area,
            'city' => $offer->city,
            'street' => $offer->street,
            'repeat' => $offer->repeat,
            'published' => $offer->published,
            'created_at' => $offer->created_at->format('d.m.Y H:i'),
            'image' => $offer->image,
        ];
    }

    public function getUsers()
    {
        return $this->user_model->select('id', 'name')->get();
    }


    public function updateOffer($request, $id)
    {
        $offer = $this->getById($id);

        $current_image = $offer->image;

        $offer->title = $request->title;

        $offer->user_id = $request->user_id;

        $offer->description = $request->description;

        if ($request->hasFile('image')) {

            $image = $request->image;

            $image_new_name = time() . $image->getClientOriginalName();

            $image->move('uploads/offers', $image_new_name);

            \File::delete('uploads/offers', $current_image);

            $offer->image = 'uploads/offers/' . $image_new_name;

        }

        $offer->save();

        return true;
    }

    public function published($id)
    {

        $statement = $this->model->find($id);

        $statement->published = true;

        $statement->published_date = Carbon::now();

        $statement->save();

        return true;
    }

    public function noPublished($id)
    {

        $statement = $this->model->find($id);

        $statement->published = false;

        $statement->published_date = Carbon::now();

        $statement->save();

        return true;
    }


}