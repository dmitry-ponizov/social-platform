<?php

namespace App\Components\Main\Repositories;

use App\Components\Admin\Models\Profile;
use App\Components\Admin\Models\Rule;
use App\Components\Admin\Models\User;
use App\Components\Main\Core\BaseRepository;
use App\Components\Main\Models\Category;
use App\Components\Main\Models\Settings;
use App\Components\Main\Models\Slider;
use App\Components\Main\Models\Statement;
use App\Mail\PasswordEmail;
use App\Components\Admin\Repositories\PartnerRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class MainRepository extends BaseRepository
{
    protected $slider_model;
    protected $statement_model;
    protected $settings_model;
    protected $category_model;
    protected $partner_repo;

    public function __construct(
        Slider $slider,
        Statement $statement,
        Settings $settings,
        Category $category,
		PartnerRepository $partnerRepository
    )
    {
        $this->slider_model = $slider;
        $this->statement_model = $statement;
        $this->settings_model = $settings;
        $this->category_model = $category;
        $this->partner_repo = $partnerRepository;
    }

    public function getSliders()
    {
        $sliders = $this->slider_model->orderBy('order')->get();


        $locale = \App::getLocale();

        $sliders_arr = [];

        foreach ($sliders as $slider) {
            $lang_title = json_decode($slider->title);
            $lang_heading = json_decode($slider->heading);
            $lang_desc = json_decode($slider->description);
            $lang_link = json_decode($slider->link_title);

            $sliders_arr[] = [
                'title' => $lang_title->$locale,
                'heading' => $lang_heading->$locale,
                'description' => $lang_desc->$locale,
                'link_title' => $lang_link->$locale,
                'image' => $slider->image,
                'order' => $slider->order,
                'id' => $slider->id
            ];
        }

        return $sliders_arr;
    }


    public function getNotSumStatements()
    {
        $statements = $this->statement_model
            ->where([
                ['parent_id', 0],
                ['status', '!=', 'closed'],
                ['published', 1]
            ])
            ->whereNull('sum')
            ->with('user', 'category')
            ->with(['images' => function ($query) {
                $query->where('main', true);
            }])
            ->orderBy('id', 'DESC')
            ->take(4)
            ->get();

        $result = [];
        foreach ($statements as $statement) {
            $date = time() - strtotime($statement->created_at);
            $result[$statement->id] = [
                'id' => $statement->id,
                'uuid' => $statement->uuid,
                'title' => $statement->title,
                'sum' => $statement->sum,
                'image' => $statement->images,
                'raised' => $statement->raised,
                'description' => $statement->description,
                'created_at' => $date,
            ];
        }

        return $result;

    }

    public function getFinanceStatements()
    {
        $statements = $this->statement_model
            ->where('sum', '!=', null)
            ->where('parent_id', 0)
            ->where('status', '!=', 'closed')
            ->where('published', 1)
            ->with('user', 'category', 'images')
            ->latest()
            ->limit(8)
            ->get();

        $result = [];


        foreach ($statements as $statement) {

            $result[$statement->id] = [
                'id' => $statement->id,
                'uuid' => $statement->uuid,
                'title' => $statement->title,
                'sum' => $statement->sum,
                'raised' => $statement->raised,
                'description' => $statement->description,
                'created_at' => Carbon::parse($statement->created_at)->format('Y.m.d h:i:s'),
            ];

            foreach ($statement->images as $image) {
                if ($image->main) {
                    $result[$statement->id]['image'] = '/uploads/statements/medium/' . $image->name;
                }
            }


        }

        return $result;
    }


    public function getCategories()
    {
        $categories = $this->category_model->where('publish',true)->get();

        $locale = \App::getLocale();

        $result = [];

        foreach ($categories as $category) {
            $lang = json_decode($category->lang);

            $result[$category->id] = [
                'id' => $category->id,
                'name' => $category->name,
                'lang' => $lang->$locale
            ];
        }

        return $result;
    }

    public function getVolunteers()
    {
        $rules = Rule::whereIn('slug', [
            'about',
            'skype',
            'facebook',
            'google',
            'twitter'
        ])->pluck('id');

        $volunteers = User::where('types', 'volunteer')->where('publish', true)
            ->with(['profiles' => function ($query) use ($rules) {
                $query->with('rule')->whereIn('rule_id', $rules);
            }])
            ->latest()->get();

        $result = [];


        foreach ($volunteers as $volunteer) {
            $result [$volunteer->id] = [
                'uuid' => $volunteer->uuid,
                'user' => $volunteer->name . ' ' . $volunteer->surname,
                'avatar' => $volunteer->avatar,
            ];
            foreach ($volunteer->profiles as $profile) {
                $result [$volunteer->id][$profile->rule->label] = $profile->data;
            }
        }

        return $result;
    }

    public function getPartners()
    {
    	return $this->partner_repo->getAllPartners(true);
    }
    public function storeVolunteerStatement($request)
    {
        $category = Category::where('name', 'Volunteer')->first();

        $user = User::where('phone', htmlspecialchars(trim($request->mobile_phone)))->first();

        if (!$user) {
            $user_id = $this->createUser($request);
        } else {
            $user_id = $user->id;
        }

        $statement = Statement::where('user_id', $user_id)
            ->where('category_id', $category->id)
            ->where('status', '!=', 'closed')
            ->first();

        if (!$statement) {
            $this->createStatement($request, $category, $user_id);
        } else {
            return false;
        }
        return true;
    }

    /**
     * @param $request
     * @param $category
     * @param $user_id
     */
    protected function createStatement($request, $category, $user_id): void
    {
        Statement::insert([
            'title' => \Lang::get('main.main.volunteers.become_volunteer'),
            'uuid' => Str::uuid(),
            'category_id' => $category->id,
            'status' => 'sent',
            'user_id' => $user_id,
            'description' => $request->message ?: '',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()

        ]);
    }

    /**
     * @param $request
     * @return mixed
     */
    protected function createUser($request)
    {
        $password = str_random(8);

        $user_id = User::insertGetId([
            'name' => htmlspecialchars(trim($request->name)),
            'uuid' => Str::uuid(),
            'phone' => htmlspecialchars(trim($request->mobile_phone)),
            'email' => htmlspecialchars(trim($request->email)),
            'avatar' => '/uploads/avatars/no_avatar.jpeg',
            'types' => 'volunteer',
            'password' => Hash::make($password),
            'created_at' => Carbon::now(),

        ]);

        $rules = Rule::whereIn('slug', ['name', 'email', 'gender', 'mobile_phone'])->pluck('id', 'slug');

        $prepare = [];

        foreach ($rules as $slug => $id) {
            $prepare[] = [
                'rule_id' => $id,
                'data' => htmlspecialchars(trim($request->$slug)),
                'user_id' => $user_id,
                'changed_at' => Carbon::now()
            ];
        }

        Profile::insert($prepare);

        Mail::to($request->email)->send(new PasswordEmail($password));

        return $user_id;
    }
}