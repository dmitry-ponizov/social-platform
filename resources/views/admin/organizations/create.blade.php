@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.organization.create')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.organization.create')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{(route('organizations.store'))}}" method="POST" enctype="multipart/form-data" class="create_social_service">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="name" type="text" value="{{ old('name') }}" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                    <div class="form-group">
                        <label for="chief">@lang('main.organization.member_name')</label>
                        <input name="user_name" type="text" value="{{ old('user_name') }}" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('user_name')}}</span>
                    <div class="form-group">
                        <label for="chief">@lang('main.organization.member_surname')</label>
                        <input name="surname" type="text" value="{{ old('surname') }}" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('surname')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.organization.member_phone')</label>
                        <input name="phone" v-mask="'+99(999)-9999999'"  value="{{ old('phone') }}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('phone')}}</span>

                    <div class="form-group">
                        <label for="name">@lang('main.social_service.city')</label>
                        <input name="city" value="{{ old('city') }}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('city')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.street')</label>
                        <input name="street" value="{{ old('street') }}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('street')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.house')</label>
                        <input name="house"  value="{{ old('house') }}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('house')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.office')</label>
                        <input name="office" value="{{ old('office') }}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('office')}}</span>

                    <div class="form-group">
                        <label for="name">@lang('main.social_service.email')</label>
                        <input name="email" value="{{ old('email') }}" type="email" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.phone')</label>
                        <input name="organization_phone" value="{{ old('organization_phone') }}" v-mask="'+99(999)-9999999'"  type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('phone')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.password')</label>
                        <input name="password" type="password" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('password')}}</span>
                    <div class="form-group service_create">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.organization.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection