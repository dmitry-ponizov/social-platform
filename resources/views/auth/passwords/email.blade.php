@extends('layouts.app')

@section('content')
    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <div class="login_wrap login">
        <div class="login_container">
            <h5 class="panel-heading">@lang('main.main.forgot.reset')</h5>
            <div class="panel-body">
                @if (session('status'))
                    <div class="ui success message">
                        <p>{{ session('status') }}</p>
                    </div>
                @endif
                <form class="form-horizontal" method="POST" action="{{ route('password.email') }}">
                    {{ csrf_field() }}
                    <div class="form_block">
                        <label for="email">@lang('main.main.login.email')</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="send_block">
                        <button style="width: 100%" type="submit" class="btn btn-primary">
                            @lang('main.main.forgot.reset_link')
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer-component></footer-component>
@endsection
