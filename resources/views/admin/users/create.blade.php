@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.user.create_user')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.user.create_user')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.name')</label>
                        <input name="name" type="text" value="{{old('name')}}" class="form-control">
                        <span class="text-danger">
                            {{$errors->first('name')}}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.main.registration.surname')</label>
                        <input name="surname" type="text" value="{{old('surname')}}" class="form-control">
                        <span class="text-danger">
                            {{ $errors->first('surname') }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('main.global.phone')</label>
                        <input name="phone" type="text" value="{{old('phone')}}" v-mask="'+99(999)-9999999'"
                               class="form-control">
                        <span class="text-danger">
                            {{ $errors->first('phone') }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="code">@lang('main.statement.code')</label>
                        <input name="code" type="number" value="{{old('code')}}" class="form-control">
                        <span class="text-danger">
                            {{ $errors->first('code') }}
                        </span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.password')</label>
                        <input name="password" type="password" class="form-control">
                        <span class="text-danger">
                            {{ $errors->first('password') }}
                        </span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">
                                @lang('main.user.create_user')
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection