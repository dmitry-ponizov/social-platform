@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.organization.history.substatement')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            @lang('main.organization.history.substatement'): {{$statement['title']}}
        </div>
        <div class="card-body">
            <div class="card-block mb-3">
                <b>@lang('main.global.title'): </b><span>{{$statement['title']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.global.user'): </b><span>{{$statement['user']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.global.category'): </b><span>{{$statement['category_title']}}</span>
            </div>

            <div class="card-block mb-3">
                <b>@lang('main.statement.region'): </b><span>{{$statement['region']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.area'): </b><span>{{$statement['area']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.city'): </b><span>{{$statement['city']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.street'): </b><span>{{$statement['street']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.global.created'): </b><span>{{$statement['created_at']}}</span>
            </div>
            @if($statement['repeat'])
                <div class="card-block mb-3">
                    <b>@lang('main.statement.repeat')</b>
                </div>
            @endif
            @if($statement['published'])
                <div class="card-block mb-3">
                    <b>@lang('main.global.publish')
                        : </b><span>{{date('d.m.Y H:i',strtotime($statement['publish_date']))}}</span>
                </div>
            @else
                <div class="card-block mb-3">
                    <b>@lang('main.global.no_publish')</b>
                </div>
            @endif
            <div class="card-block mb-3">
                <b>@lang('main.global.description'): </b><span>{{$statement['description']}}</span>
            </div>

            @foreach($statement['images'] as $image)
                <div class="card-block mb-3">
                    <a href="/uploads/statements/thumb/{{$image->name}}" target="_blank"
                       class="link-image js-zoom-image">
                        <img width="80px" height="50px" src="/uploads/statements/small/{{$image->name}}">
                    </a>
                </div>

            @endforeach

        </div>
    </div>
@endsection

