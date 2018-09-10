@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.slider')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i>@lang('main.menu.slides')
            </div>
            <a href="{{route('slider.create')}}" class="btn btn-primary"> + @lang('main.slider.create_slider')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover">
                    <thead>
                    <th>@lang('main.global.image')</th>
                    <th>@lang('main.global.title')</th>
                    <th>@lang('main.global.heading')</th>
                    <th>@lang('main.global.description')</th>
                    <th>@lang('main.global.display_order')</th>
                    @foreach($data['fields'] as $permission=>$field)
                        @if($permission!='create_slider')
                            <th>{{$field['th_name']}}</th>
                        @endif
                    @endforeach
                    </thead>
                    <tbody>

                    @forelse($data['sliders'] as $slider)
                        <tr>
                            <td><img src="{{asset($slider['image'])}}" alt="" width="200px" height="100px"></td>
                            <td>{{$slider['title']}}</td>
                            <td>{{$slider['heading']}}</td>
                            <td>{{$slider['description']}}</td>
                            <td>{{$slider['order']}}</td>
                            @foreach($data['fields'] as $permission=>$field)
                                @if($permission!='create_slider')
                                    <td><a href="{{route($field['route'],$slider['id'])}}"
                                           class="btn btn-xs {{$field['button']}}">{{$field['name']}}</a></td>
                                @endif
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.user.no_users')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

            </div>
        </div>
    </div>

@endsection