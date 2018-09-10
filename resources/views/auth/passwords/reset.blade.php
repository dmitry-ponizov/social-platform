@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <div class="login_wrap login">
        <div class="login_container">
            <h5>@lang('main.main.forgot.reset')</h5>
            <div class="panel-body">
                <form class="form-horizontal" method="POST" action="{{ route('password.request') }}">
                    {{ csrf_field() }}
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form_block">
                        <label for="email">@lang('main.main.login.email')</label>
                        <input id="email" type="email" class="form-control" name="email"
                               value="{{ $email or old('email') }}" required autofocus>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form_block">
                        <label for="password" class="col-md-4 control-label">@lang('main.main.login.password')</label>
                        <input id="password" type="password" class="form-control" name="password" required>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form_block">
                        <label for="password-confirm" class="col-md-4 control-label">@lang('main.main.forgot.confirm')</label>
                        <input id="password-confirm" type="password" class="form-control"
                               name="password_confirmation" required>
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="send_block">
                        <button type="submit"  style="width: 100%" class="btn btn-primary">
                               @lang('main.main.forgot.reset_pass')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>



    <footer-component></footer-component>
@endsection
