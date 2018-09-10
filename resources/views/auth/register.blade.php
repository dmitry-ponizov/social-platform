@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <div>
        <div class="login_wrap">
            <div class="login_container">
                <h5>@lang('main.main.registration.registration')</h5>
                <registration-component :lang="{{json_encode(\Lang::get('main.main'))}}"></registration-component>
            </div>
        </div>
    </div>
    <footer-component></footer-component>
@endsection
