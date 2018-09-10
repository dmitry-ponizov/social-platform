@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.social_services')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.social_service.create')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.social_service.create')
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('social_service.store')}}" method="POST" enctype="multipart/form-data" class="create_social_service">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="org_name" type="text" value="{{old('org_name')}}" class="form-control">

                    </div>
                    <span class="text-danger">{{$errors->first('name')}}</span>

                    <div class="form-group">
                        <label for="chief">@lang('main.social_service.chief_name')</label>
                        <input name="name" type="text" {{old('name')}} class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                    <div class="form-group">
                        <label for="chief">@lang('main.social_service.chief_surname')</label>
                        <input name="surname" type="text" {{old('surname')}} class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('surname')}}</span>

                    <div class="form-group">
                        <label for="name">@lang('main.social_service.city')</label>
                        <input name="city" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('city')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.street')</label>
                        <input name="street" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('street')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.house')</label>
                        <input name="house" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('house')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.office')</label>
                        <input name="office" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('office')}}</span>

                    <div class="form-group">
                        <label for="name">@lang('main.social_service.email')</label>
                        <input name="email" type="email" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.phone')</label>
                        <input name="phone" v-mask="'+99(999)-9999999'" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('phone')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.password')</label>
                        <input name="password" type="password" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('password')}}</span>
                    <div class="form-group service_create">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.social_service.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection