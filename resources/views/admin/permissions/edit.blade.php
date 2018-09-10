@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.permission.edit_permission')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.permission.edit_permission'): {{$permission->locale}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('permission.update',$permission->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="label" type="text" value="{{$permission->label}}" class="form-control">
                        <span class="text-danger">{{$errors->first('label')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.permission.type')</label>
                        <select name="type"  class="form-control">
                            @foreach($types as $type)
                                <option {{($permission->type == $type) ? 'selected':''}} value="{{$type}}">@lang('main.permission.'.$type)</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text" value="{{$permission->lang->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text"  value="{{$permission->lang->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text"   value="{{$permission->lang->en}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.permission.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection