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
        {{-- {{dd($fields)}} --}}
        <div class="card-body">
            <form action="{{route('quick_donate.update')}}" method="POST" id="left_banner_form" enctype="multipart/form-data">
                {{csrf_field()}}
                <table class="table table-hover table-statements">
                    <thead>
                    <th>Title</th>
                    <th>en</th>
                    <th>ru</th>
                    <th>ua</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.heading')</label></td>
                        <td><input type="text" name="heading[en]" class="form-control" value="{{$fields['en']->heading}}">
                        </td>
                        <td><input type="text" name="heading[ru]" class="form-control" value="{{$fields['ru']->heading}}">
                        </td>
                        <td><input type="text" name="heading[ua]" class="form-control" value="{{$fields['ua']->heading}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_1')</label></td>
                        <td><input type="text" name="title_1[en]" class="form-control" value="{{$fields['en']->title_1}}">
                        </td>
                        <td><input type="text" name="title_1[ru]" class="form-control" value="{{$fields['ru']->title_1}}">
                        </td>
                        <td><input type="text" name="title_1[ua]" class="form-control" value="{{$fields['ua']->title_1}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_2')</label></td>
                        <td><input type="text" name="title_2[en]" class="form-control" value="{{$fields['en']->title_2}}">
                        </td>
                        <td><input type="text" name="title_2[ru]" class="form-control" value="{{$fields['ru']->title_2}}">
                        </td>
                        <td><input type="text" name="title_2[ua]" class="form-control" value="{{$fields['ua']->title_2}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_3')</label></td>
                        <td><input type="text" name="title_3[en]" class="form-control" value="{{$fields['en']->title_3}}">
                        </td>
                        <td><input type="text" name="title_3[ru]" class="form-control" value="{{$fields['ru']->title_3}}">
                        </td>
                        <td><input type="text" name="title_3[ua]" class="form-control" value="{{$fields['ua']->title_3}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_4')</label></td>
                        <td><input type="text" name="title_4[en]" class="form-control" value="{{$fields['en']->title_4}}">
                        </td>
                        <td><input type="text" name="title_4[ru]" class="form-control" value="{{$fields['ru']->title_4}}">
                        </td>
                        <td><input type="text" name="title_4[ua]" class="form-control" value="{{$fields['ua']->title_4}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_title')</label></td>
                        <td><input type="text" name="link_title[en]" class="form-control" value="{{$fields['en']->link_title}}">
                        </td>
                        <td><input type="text" name="link_title[ru]" class="form-control" value="{{$fields['ru']->link_title}}">
                        </td>
                        <td><input type="text" name="link_title[ua]" class="form-control" value="{{$fields['ua']->link_title}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_url')</label></td>
                        <td><input type="text" name="link_url" class="form-control"
                                   value="{{$fields['en']->link_url}}"></td>

                    </tr>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.background')</span></td>
                        <td>
                            <label>
                                <img src="{{$fields['ru']->background}}" alt="">
                                <input type="file"  name="background">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.payment_img')</span></td>
                        <td>
                            <label>
                                <img src="{{$fields['ru']->payment_img}}" alt="">
                                <input type="file"  name="payment_img">
                            </label>
                        </td>
                    </tr>

                    </tbody>
                </table>
                <button class="btn btn-xs btn-success">@lang('main.elements.save')</button>
            </form>
        </div>

    </div>

@endsection