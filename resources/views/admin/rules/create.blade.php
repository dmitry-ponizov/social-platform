@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.rule.create')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            @lang('main.rule.create')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('rule.store')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="label">@lang('main.global.title')</label>
                        <input name="label" type="text" value="{{old('label')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('label')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="type">@lang('main.rule.type')</label>

                        <select name="type" class="form-control">
                            @foreach($types as $key=>$type)
                                <option value="{{$key}}">{{$type}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{$errors->first('type')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="type">@lang('main.rule.group')</label>
                        <select name="group" class="form-control">
                            @foreach($groups as $id=>$group)
                                <option value="{{$id}}">{{$group['title']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{$errors->first('type')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.rule.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection