@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            @lang('main.global.settings')
        </li>
         <li class="breadcrumb-item">
            <a href="{{route('pages')}}">@lang('main.menu.pages')</a>
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
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-statements">
                    <thead class="thead-dark">
                    <th>@lang('main.global.title')</th>
                    <th>@lang('main.pages.content')</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td>
                            @lang('main.menu.slider')
                        </td>
                        <td>
                            <a class="btn btn-sm btn-secondary" href="{{route('sliders')}}">
                                @lang('main.global.edit')
                            </a>
                        </td>
                    </tr>
                    @foreach($elements as $name=> $element)
                        <tr>
                            <td>@lang("main.elements.".$element)</td>
                            <td>
                                <a href="{{route('element.content',$element)}}" class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            </td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection