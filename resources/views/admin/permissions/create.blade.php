@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.permission.create')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            @lang('main.permission.create')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('permission.store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="label" type="text" value="{{old('label')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('label')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.permission.type')</label>
                        <select name="type"  class="form-control">
                            <option value="admin">@lang('main.permission.admin')</option>
                            <option value="social">@lang('main.permission.social')</option>
                            <option value="volunteer">@lang('main.permission.volunteer')</option>
                            <option value="organization">@lang('main.permission.organization')</option>
                        </select>
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text"  class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text"  class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.permission.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection