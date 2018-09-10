@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.organization.edit')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.organization.edit')
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('organizations.update',$organization->id)}}" method="POST" enctype="multipart/form-data" class="create_social_service">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="name" value="{{$organization->name}}" type="text"  class="form-control">

                    </div>
                    <span class="text-danger">{{$errors->first('name')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.city')</label>
                        <input name="city" type="text" class="form-control" value="{{$organization->city}}">
                    </div>
                    <span class="text-danger">{{$errors->first('city')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.street')</label>
                        <input name="street"  value="{{$organization->street}}" type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('street')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.house')</label>
                        <input name="house" value="{{$organization->house}}"  type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('house')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.office')</label>
                        <input name="office"  value="{{$organization->office}}"  type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('office')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.phone')</label>
                        <input name="phone"  value="{{$organization->phone}}"  type="text" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('phone')}}</span>
                    <div class="form-group">
                        <label for="name">@lang('main.social_service.email')</label>
                        <input name="email"  value="{{$organization->email}}"  type="email" class="form-control">
                    </div>
                    <span class="text-danger">{{$errors->first('email')}}</span>
                    <div class="form-group service_create">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.social_service.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection