@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.user.edit_user')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user" aria-hidden="true"></i>
                @lang('main.user.edit_user'): {{$user->name}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('user.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.name')</label>
                        <input name="name" type="text" value="{{$user->name}}" class="form-control">
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.user.surname')</label>
                        <input name="surname" type="text" value="{{$user->surname}}" class="form-control">
                        <span class="text-danger">{{$errors->first('surname')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('main.global.phone')</label>
                        <input name="mobile_phone" type="text" v-mask="'+99(999)-9999999'"  value="{{ $user->phone }}" class="form-control">
                        <span class="text-danger">{{$errors->first('mobile_phone')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="code">@lang('main.statement.code')</label>
                        <input name="identification_number" type="number" value="{{ isset($user->profiles[0]->data) ? $user->profiles[0]->data :'' }}"  class="form-control">
                        <span class="text-danger">{{$errors->first('identification_number')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.user.new_password')</label>
                        <input name="password" type="password" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.user.upload_new_avatar')</label>
                        <input name="avatar" type="file" class="form-control">
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.user.update_user')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection