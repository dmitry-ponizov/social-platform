<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller
{
    public function changeLanguage(Request $request)
    {
        $localization = [
            'ru',
            'en',
            'ua'
        ];

        if (in_array($request->get('locale'), $localization)) {
            $local = $request->get('locale');

            $request->session()->put('locale', $local);

            return 'ok';
        }


    }

    public function getLanguage()
    {
        if (Session::has('locale')) {
            return Session::get('locale');
        } else {
            return \Config::get('app.locale');
        }

    }
}
