@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            @lang('main.global.settings')
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.elements')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.menu.elements')
            </div>
        </div>
        <div class="card-body">
            <form action="{{route('banner.update.left')}}" method="POST" id="left_banner_form" enctype="multipart/form-data">
                {{csrf_field()}}
                <table class="table table-hover table-statements table-bordered text-center">
                    <thead class="thead-dark">
                    <th>Title</th>
                    <th>en</th>
                    <th>ru</th>
                    <th>ua</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title')</label></td>
                        <td><input type="text" name="title[en]" class="form-control" value="{{$fields['en']->title}}">
                        </td>
                        <td><input type="text" name="title[ru]" class="form-control" value="{{$fields['ru']->title}}">
                        </td>
                        <td><input type="text" name="title[ua]" class="form-control" value="{{$fields['ua']->title}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.heading_1')</label></td>
                        <td><input type="text" name="heading_1[en]" class="form-control"
                                   value="{{$fields['en']->heading_1}}"></td>
                        <td><input type="text" name="heading_1[ru]" class="form-control"
                                   value="{{$fields['ru']->heading_1}}"></td>
                        <td><input type="text" name="heading_1[ua]" class="form-control"
                                   value="{{$fields['ua']->heading_1}}"></td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.description_1')</label></td>
                        <td><textarea type="text" name="description_1[en]"
                                      class="form-control">{{$fields['en']->description_1}}</textarea></td>
                        <td><textarea type="text" name="description_1[ru]"
                                      class="form-control">{{$fields['ru']->description_1}}</textarea></td>
                        <td><textarea type="text" name="description_1[ua]"
                                      class="form-control">{{$fields['ua']->description_1}}</textarea></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.heading_2')</label></td>
                        <td><input type="text" name="heading_2[en]" class="form-control"
                                   value="{{$fields['en']->heading_2}}"></td>
                        <td><input type="text" name="heading_2[ru]" class="form-control"
                                   value="{{$fields['ru']->heading_2}}"></td>
                        <td><input type="text" name="heading_2[ua]" class="form-control"
                                   value="{{$fields['ua']->heading_2}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.description_2')</label></td>
                        <td><textarea type="text" name="description_2[en]"
                                      class="form-control">{{$fields['en']->description_2}}</textarea></td>
                        <td><textarea type="text" name="description_2[ru]"
                                      class="form-control">{{$fields['ru']->description_2}}</textarea></td>
                        <td><textarea type="text" name="description_2[ua]"
                                      class="form-control">{{$fields['ua']->description_2}}</textarea></td>
                    </tr>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.icon_1')</span></td>
                        <td colspan="3">
                            <label>
                                <img src="{{$fields['ru']->icon_1}}" alt="">
                                <input type="file" name="icon_1">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.icon_2')</span></td>
                        <td colspan="3">
                            <label>
                                <img src="{{$fields['ru']->icon_2}}" alt="">
                                <input type="file" name="icon_2">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.background')</span></td>
                        <td colspan="3">
                        <label>
                            <img src="{{$fields['ru']->background}}" alt="">
                            <input type="file"  name="background">
                        </label>
                        </td>
                    </tr>
                    
                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-xs btn-success">@lang('main.elements.save')</button>
                </div>

            </form>
        </div>

    </div>

@endsection