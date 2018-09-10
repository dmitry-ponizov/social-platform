@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.social_service.create_co_work')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.social_service.create_co_work')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('social_service.store.co_work',$id)}}" method="POST" enctype="multipart/form-data"
                      class="co_work_form">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.name')</label>
                        <input name="name" type="text" value="{{old('name')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.main.registration.surname')</label>
                        <input name="surname" type="text" value="{{old('surname')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('surname')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.main.registration.position')</label>
                        <input name="position" type="text" value="{{old('position')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('position')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="phone">@lang('main.global.phone')</label>
                        <input name="phone"  v-mask="'+99(999)-9999999'"  type="text" {{old('phone')}} class="form-control">
                        <span class="text-danger">{{$errors->first('phone')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.password')</label>
                        <input name="password" type="password" class="form-control">
                        <span class="text-danger">{{$errors->first('password')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-right">
                            <button class="btn btn-dark"
                                    type="submit">@lang('main.social_service.create_co_work')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection