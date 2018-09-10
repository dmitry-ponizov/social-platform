@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <login-view class="login" inline-template>
        <div class="login_wrap">
            <div class="login_container">
                <h5>@lang('main.main.login.login')</h5>
                <form method="POST" action="{{ route('login') }}">
                    {{ csrf_field() }}
                    <div class="form_block">
                        <label for="phone">@lang('main.main.login.phone')</label>
                        <input type="text" name="phone" v-model="phone" v-mask="'+99(999)-9999999'" />
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <strong>{{ $errors->first('phone') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form_block">
                        <label for="password">@lang('main.main.login.password')</label>
                        <input name="password" type="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form_block">
                        <div class="remember">
                            <input name="remember" id="remember" type="checkbox">
                            <label for="remember">@lang('main.main.login.remember')</label>
                            <a href="/password/reset" class="forgot_pass">@lang('main.main.login.forgot')</a>
                        </div>

                    </div>
                    <div class="send_block">
                        <button class="send_btn" type="submit">
                            @lang('main.main.login.login')
                        </button>
                        <div class="reg_block">
                            <a href="/register">@lang('main.main.registration.registration')</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </login-view>
    <footer-component></footer-component>
@endsection
