@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.offer.view')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.offer.view'): {{$offer['title']}}
            </div>

        </div>
        <div class="card-body">
            <div class="card-block mb-3">
                <b>@lang('main.global.title'): </b><span>{{$offer['title']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.global.user'): </b><span>{{$offer['user']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.region'): </b><span>{{$offer['region']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.area'): </b><span>{{$offer['area']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.city'): </b><span>{{$offer['city']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.statement.street'): </b><span>{{$offer['street']}}</span>
            </div>
            <div class="card-block mb-3">
                <b>@lang('main.global.created'): </b><span>{{$offer['created_at']}}</span>
            </div>
            @if($offer['repeat'])
                <div class="card-block mb-3">
                    <b>@lang('main.statement.repeat')</b>
                </div>
            @endif
            @if($offer['published'])
                <div class="card-block mb-3">
                    <b>@lang('main.global.publish'): </b><span>{{date('d.m.Y H:i',strtotime($offer['publish_date']))}}</span>
                </div>
            @else
                <div class="card-block mb-3">
                    <b>@lang('main.global.no_publish')</b>
                </div>
            @endif
            @if(!empty($offer['accept_date']))
                <div class="card-block mb-3">
                    <b>@lang('main.global.accept'): </b><span>{{date('d.m.Y H:i',strtotime($offer['accept_date']))}}</span>
                </div>
            @endif
            @if(!empty($offer['close_date']))
                <div class="card-block mb-3">
                    <b>@lang('main.global.close'): </b><span>{{date('d.m.Y H:i',strtotime($offer['close_date']))}}</span>
                </div>
            @endif
            <div class="card-block mb-3">
                <b>@lang('main.global.description'): </b><span>{{$offer['description']}}</span>
            </div>
            @if(isset($offer['image']))
                <div class="card-block mb-3">
                    <b>@lang('main.global.image'): </b>
                    <a href="{{asset($offer['image'])}}" target="_blank" class="link-image js-zoom-image">
                        <img width="80px" height="50px" src="{{asset($offer['image'])}}">
                    </a>
                </div>
            @endif
        </div>
    </div>

@endsection

