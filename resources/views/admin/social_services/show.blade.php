@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('social_services')}}">@lang('main.global.social_services')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.social_service.view')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-info-circle fa-fw"></i>@lang('main.social_service.info'):
            </div>
        </div>
        <div class="card-body">
            <div class="social_service_wrap">
                <div class="info_social">
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.name'): </b><span>{{$social_service->name}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.city'): </b><span>{{$social_service->city}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.street'): </b><span>{{$social_service->street}}</span>
                    </div>

                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.house'): </b><span>{{$social_service->house}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.office'): </b><span>{{$social_service->office}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.phone'): </b><span>{{$social_service->phone}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.email'): </b><span>{{$social_service->email}}</span>
                    </div>

                    <div class="card-block mb-3">
                        <a href="{{route('create.co_work',$social_service->id)}}"
                           class="btn btn-secondary btn-sm">@lang('main.social_service.add_co_work')</a>
                        <a href="{{route('social_service.statement.create',$social_service->id)}}"
                           class="btn brn-xs btn-primary btn-sm">@lang('main.statement.form_title')</a>
                    </div>
                </div>
                <div class="co_workers">
                    <table class="table table-hover">
                        <thead>
                            <th>@lang('main.user.surname')</th>
                            <th>@lang('main.user.name')</th>
                            <th>@lang('main.user.position')</th>
                            <th>@lang('main.user.permissions')</th>
                            <th>@lang('main.global.delete')</th>
                        </thead>
                        <tbody>
                        @forelse($social_service->users as $user)
                            <tr>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->name}} </td>
                                <td>{{$user->position}} </td>
                                <td><a href="{{route('user.edit.permissions',$user->id)}}" class="btn btn-xs btn-secondary">@lang('main.global.view')</a></td>
                                <td><a href="{{route('user.delete',$user->id)}}" class="btn btn-xs btn-danger">@lang('main.global.delete')</a></td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="4" class="text-center">@lang('main.social_service.no_co_works')</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

