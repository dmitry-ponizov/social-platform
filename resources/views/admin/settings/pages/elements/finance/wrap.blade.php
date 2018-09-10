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
            <form action="{{route('finance.update')}}" method="POST" id="left_banner_form"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <table class="table table-hover table-statements table-bordered">
                    <thead class="thead-dark">
                    <th>@lang('main.global.title')</th>
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
                        <td><label class="form-label">@lang('main.elements.heading')</label></td>
                        <td><input type="text" name="heading[en]" class="form-control"
                                   value="{{$fields['en']->heading}}"></td>
                        <td><input type="text" name="heading[ru]" class="form-control"
                                   value="{{$fields['ru']->heading}}"></td>
                        <td><input type="text" name="heading[ua]" class="form-control"
                                   value="{{$fields['ua']->heading}}"></td>
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