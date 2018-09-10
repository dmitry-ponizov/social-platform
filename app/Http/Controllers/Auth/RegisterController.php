<?php

namespace App\Http\Controllers\Auth;

use App\Components\Admin\Models\Rule;
use App\Components\Admin\Models\User;
use App\Http\Controllers\Controller;
use App\Rules\Recaptcha;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\Components\Admin\Models\Profile;
use App\Components\Admin\Models\Organization;
use App\Components\Main\Models\Settings;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array $data
     * @param Recaptcha $recaptcha
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {

        return Validator::make($data, [
            'name' => 'required|string|max:32',
            'surname' => 'required|string|max:32',
            'organization' => 'required_if:type,organization',
            'phone' => [
                'required',
                'unique:users',
                'regex:/(?:\+|\d)[\d\-\(\) ]{14}\d/'
            ],
            'password' => 'required|string|min:6|confirmed',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'uuid' => Str::uuid(),
            'phone' => $data['phone'],
            'types' => $data['type'],
            'password' => Hash::make($data['password']),
            'avatar' => '/uploads/avatars/no_avatar.jpeg'
        ]);

        $rules = Rule::whereIn('label', ['name', 'mobile phone', 'surname'])->get();

        $profiles = [];
        foreach ($rules as $rule){
            $profiles[] =[
                'user_id' => $user->id,
                'rule_id' => $rule->id,
                'data' => $rule->label === 'mobile phone' ? $data['phone'] : $data[$rule->label],
                'accepted' => false,
                'changed_at' => Carbon::now()
            ];
        }

        Profile::insert($profiles);

        if ($data['type'] == 'organization') {
            $org_id = Organization::create([
                'name' => $data['organization'],
                'created_at' => Carbon::now()
            ]);

            $user->types = 'volunteer';

            $user->organization_id = $org_id->id;

            $user->save();

        }

        return $user;
    }

    public function showRegistrationForm()
    {
        $settings = Settings::where('page_slug', 'main')->whereIn('key', ['footer', 'header'])->get();

        $locale = \App::getLocale();

        $result = [];

        foreach ($settings as $setting) {
            if ($locale == 'en') {

                $result[$setting->key] = [
                    'element' => json_decode($setting->element),

                ];
            } else {
                $lang = json_decode($setting->lang);

                $result[$setting->key] = [
                    'element' => $lang->$locale,

                ];

            }

        }

        $data = [

            'settings' => $result,

        ];
        return view('auth.register', $data);
    }
}
