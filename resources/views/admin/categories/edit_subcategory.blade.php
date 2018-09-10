@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('subcategories', $subcategory['parent_slug']) }}">@lang('main.category.subcategories.subcategories_list')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.category.subcategories.subcategories_edit')</li>
    </ol>

    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.category.subcategories.subcategories_edit'): {{$subcategory['name']}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('subcategory.update', $subcategory['slug'])}}" method="POST"
                      enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="name" type="text" value="{{ $subcategory['slug'] }}" class="form-control">
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    </div>

                    <div class="form-group">
                        <label for="category">@lang('main.category.category')</label>
                        <select name="parent_id" class="form-control" id="category">
                            @foreach($categories as $category)
                                <option
                                       {{ ($subcategory['parent_slug'] === $category['slug']) ? 'selected' : ''}}
                                        value="{{ $category['id'] }}">
                                    {{ $category['name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Ru</label>
                        <input name="lang[ru]" type="text" value="{{$subcategory['lang']->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">Ua</label>
                        <input name="lang[ua]" type="text" value="{{$subcategory['lang']->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">En</label>
                        <input name="lang[en]" type="text" value="{{$subcategory['lang']->en}}" class="form-control">
                        <span class="text-danger">{{$errors->first('lang.en')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.category.subcategories.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection