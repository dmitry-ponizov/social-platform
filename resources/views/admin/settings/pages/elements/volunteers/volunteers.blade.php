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
            <form action="{{route('volunteer.count.update')}}" method="POST" id="left_banner_form"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <table class="table table-hover table-statements table-bordered text-center">
                    <thead class="thead-dark">
                    <th>@lang('main.global.title')</th>
                    <th></th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.count_slides')</label></td>
                        <td><input type="text" name="count_slides" class="form-control"
                                   value="{{$fields['en']->count}}">
                            <span class="text-danger">{{$errors->first('count')}}</span>
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