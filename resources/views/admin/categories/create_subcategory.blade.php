@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.category.subcategories.create')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            @lang('main.category.subcategories.create')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('subcategories.store', $slug)}}" method="POST" >
                    @csrf
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="name" type="text" value="{{old('name')}}" class="form-control">
                        <span class="text-danger">{{$errors->first('name')}}</span>

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
                            <button class="btn btn-dark" type="submit">@lang('main.category.subcategories.create')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection