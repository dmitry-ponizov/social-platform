@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.group.edit_subgroup')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.group.edit_subgroup'): {{$subgroup->locale}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('subgroup.update',$subgroup->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="label">@lang('main.global.title')</label>
                        <input name="label" type="text" value="{{$subgroup->label}}" class="form-control">
                        <span class="text-danger">{{$errors->first('label')}}</span>
                    </div>
                    <div class="form-group">
                        <label >@lang('main.group.group')</label>
                        <select name="parent" id="" class="form-control">
                            @foreach($parent_groups as $id=>$group)
                                <option value="{{$id}}">{{$group['title']}}</option>
                            @endforeach
                        </select>
                        <span class="text-danger">{{$errors->first('parent')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text" value="{{$subgroup->lang->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text" value="{{$subgroup->lang->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text" value="{{$subgroup->lang->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.group.subgroup_update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection