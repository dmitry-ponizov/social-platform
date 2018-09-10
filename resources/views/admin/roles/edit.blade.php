@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.role.edit')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.role.edit'): {{$role->locale}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('role.update',$role->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.name')</label>
                        <input name="name" type="text" value="{{$role->name}}" class="form-control">
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text" value="{{$role->lang->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text"  value="{{$role->lang->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text"   value="{{$role->lang->en}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.role.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection