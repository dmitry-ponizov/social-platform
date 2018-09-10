@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('pages')}}">@lang('main.menu.pages')</a>
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
            <div class="table-responsive">
                <table class="table table-hover table-statements table-bordered text-center">
                    <thead class="thead-dark">
                    <th>@lang('main.elements.position')</th>
                    <th>@lang('main.elements.show')</th>
                    <th>@lang('main.global.edit')</th>
                    </thead>
                    <tbody>
                    @foreach($contents as $name=> $data)
                        <tr>
                            <td>@lang("main.elements.".$name)</td>
                            <td>
                                <a href="{{route($data['route'],['element'=>$data['element'],'mod'=>$name])}}"
                                   class="{{$data['btn']}}">{{$data['title']}}</a>
                            </td>
                            <td>
                            @if($data['count']>1)
                                <a href="{{route('edit.element',['element'=>$data['element'],'mod'=>$name])}}"
                                       class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            @endif
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection