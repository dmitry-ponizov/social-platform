@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('partners')}}">@lang('main.menu.partners')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.create_partner')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user-plus" aria-hidden="true"></i>
                @lang('main.menu.create_partner')
            </div>
        </div>
        <div class="card-body">
            <create-partner :lang="{{ json_encode(\Lang::get('main.events')) }}" />
        </div>
    </div>
@endsection