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
            <form action="{{route('header.update')}}" method="POST" id="left_banner_form" enctype="multipart/form-data">
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
                        <td><span class="form-label">@lang('main.elements.logo')</span></td>
                        <td colspan="3">
                            <label>
                                <img src="{{$fields['ru']->logo}}" alt="">
                                <input type="file"  name="logo">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.phone')</label></td>
                        <td><input type="text" name="phone[en]" class="form-control" value="{{$fields['en']->phone}}"></td>
                        <td><input type="text" name="phone[ru]" class="form-control" value="{{$fields['ru']->phone}}"></td>
                        <td><input type="text" name="phone[ua]" class="form-control" value="{{$fields['ua']->phone}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.working_hours')</label></td>
                        <td><input type="text" name="working_hours[en]" class="form-control" value="{{$fields['en']->working_hours}}"></td>
                        <td><input type="text" name="working_hours[ru]" class="form-control" value="{{$fields['ru']->working_hours}}"></td>
                        <td><input type="text" name="working_hours[ua]" class="form-control" value="{{$fields['ua']->working_hours}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.email')</label></td>
                        <td><input type="text" name="email[en]" class="form-control" value="{{$fields['en']->email}}"></td>
                        <td><input type="text" name="email[ru]" class="form-control" value="{{$fields['ru']->email}}"></td>
                        <td><input type="text" name="email[ua]" class="form-control" value="{{$fields['ua']->email}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_1')</label></td>
                        <td><input type="text" name="title_1[en]" class="form-control" value="{{$fields['en']->title_1}}"></td>
                        <td><input type="text" name="title_1[ru]" class="form-control" value="{{$fields['ru']->title_1}}"></td>
                        <td><input type="text" name="title_1[ua]" class="form-control" value="{{$fields['ua']->title_1}}"></td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_1')</label></td>
                        <td colspan="3"><input type="text" name="link_1" class="form-control" value="{{$fields['en']->link_1}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_2')</label></td>
                        <td><input type="text" name="title_2[en]" class="form-control" value="{{$fields['en']->title_2}}"></td>
                        <td><input type="text" name="title_2[ru]" class="form-control" value="{{$fields['ru']->title_2}}"></td>
                        <td><input type="text" name="title_2[ua]" class="form-control" value="{{$fields['ua']->title_2}}"></td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_2')</label></td>
                        <td colspan="3"><input type="text" name="link_2" class="form-control" value="{{$fields['en']->link_2}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.title_3')</label></td>
                        <td><input type="text" name="title_3[en]" class="form-control" value="{{$fields['en']->title_3}}"></td>
                        <td><input type="text" name="title_3[ru]" class="form-control" value="{{$fields['ru']->title_3}}"></td>
                        <td><input type="text" name="title_3[ua]" class="form-control" value="{{$fields['ua']->title_3}}"></td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_3')</label></td>
                        <td colspan="3"><input type="text" name="link_3" class="form-control" value="{{$fields['en']->link_3}}"></td>
                    </tr>
                    </tbody>
                </table>
                <div class="d-flex justify-content-end">
                    <button class="btn  btn-success">@lang('main.elements.save')</button>
                </div>

            </form>
        </div>

    </div>

@endsection