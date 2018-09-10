@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.slider.edit_slider')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <i class="fa fa-fw fa-picture-o" aria-hidden="true"></i>

            @lang('main.slider.edit_slider')
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('slider.update',$slider->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    {{--<div class="form-group">--}}
                    {{--<label for="name">@lang('main.global.title')</label>--}}
                    {{--<input name="title" type="text" value="{{old('title')}}" class="form-control">--}}
                    {{--<span class="text-danger">{{$errors->first('title')}}</span>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label for="name">@lang('main.global.title') Ru</label>
                        <input name="title[ru]" type="text" value="{{$slider->title->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('title.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.title') Ua</label>
                        <input name="title[ua]" type="text" value="{{$slider->title->ua}}" class="form-control">
                        <span class="text-danger">{{$errors->first('title.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.title') En</label>
                        <input name="title[en]" type="text"  value="{{$slider->title->en}}" class="form-control">
                        <span class="text-danger">{{$errors->first('title.en')}}</span>
                    </div>

                    {{--<div class="form-group">--}}
                    {{--<label for="name">@lang('main.global.heading')</label>--}}
                    {{--<input name="heading" type="text" value="{{old('heading')}}" class="form-control">--}}
                    {{--<span class="text-danger">{{$errors->first('heading')}}</span>--}}
                    {{--</div>--}}


                    <div class="form-group">
                        <label for="name">@lang('main.global.heading') Ru</label>
                        <input name="heading[ru]" type="text" value="{{$slider->heading->ru}}" class="form-control">
                        <span class="text-danger">{{$errors->first('heading.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.heading') Ua</label>
                        <input name="heading[ua]" value="{{$slider->heading->ua}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('heading.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.heading') En</label>
                        <input name="heading[en]" value="{{$slider->heading->en}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('heading.en')}}</span>
                    </div>

                    {{--<div class="form-group">--}}
                    {{--<label for="name">@lang('main.global.description')</label>--}}
                    {{--<input name="description" type="text" value="{{old('description')}}" class="form-control">--}}
                    {{--<span class="text-danger">{{$errors->first('description')}}</span>--}}
                    {{--</div>--}}

                    <div class="form-group">
                        <label for="name">@lang('main.global.description') Ru</label>
                        <input name="description[ru]" value="{{$slider->description->ru}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('description.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.description') Ua</label>
                        <input name="description[ua]" value="{{$slider->description->ua}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('description.ua')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.description') En</label>
                        <input name="description[en]" value="{{$slider->description->en}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('description.en')}}</span>
                    </div>

                      <div class="form-group">
                        <label for="name">@lang('main.elements.link_title') En</label>
                        <input name="link_title[en]" value="{{$slider->link_title->en}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('link_title.en')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.elements.link_title') Ru</label>
                        <input name="link_title[ru]" value="{{$slider->link_title->ru}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('link_title.ru')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.elements.link_title') Ua</label>
                        <input name="link_title[ua]" value="{{$slider->link_title->ua}}" type="text" class="form-control">
                        <span class="text-danger">{{$errors->first('link_title.ua')}}</span>
                    </div>

                    <div class="form-group">
                        <label for="name">@lang('main.global.image')(2560x400)</label>
                        <input name="image" type="file"  class="form-control">
                        <span></span>
                        <span class="text-danger">{{$errors->first('image')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.slider.sort')</label>
                        <input  name="order" id="numeric_input" type="number" value="{{$slider->order}}" class="form-control">
                        <span class="text-danger">{{$errors->first('order')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.slider.edit_slider')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection