<?php

namespace App\Http\Controllers\Auth;

use App\Components\Admin\Models\User;
use App\Components\Main\Models\Settings;
use App\Components\Main\Repositories\MainRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Lang;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $main_repository;

    public function __construct(MainRepository $main)
    {
        $this->middleware('guest')->except('logout');
        $this->main_repository = $main;
    }
    protected function sendFailedLoginResponse(Request $request)
    {
        throw ValidationException::withMessages([
            $this->username() => [Lang::get('validation.failed')],
        ]);
    }
    public function username()
    {
        return 'phone';
    }

    public function showLoginForm()
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
        return view('auth.login', $data);
    }

    public function login(Request $request)
    {
        $this->validateLogin($request);

        $user = User::where('phone', $request->phone)->first();

        if (!empty($user)) {
            $this->checkBlockUser($user);
        }

        if ($this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }


        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }

    /**
     * @param Request $request
     * @param $user
     * @throws ValidationException
     */
    protected function checkBlockUser($user): void
    {
        if ($user->block) {
            throw ValidationException::withMessages([
                $this->username() => [trans(Lang::get('main.user.blocked'))],
            ]);
        }
    }

}
