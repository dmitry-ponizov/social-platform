@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('social_services')}}">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.organization.view')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-info-circle fa-fw"></i>@lang('main.organization.info'):
            </div>
        </div>
        <div class="card-body">
            <div class="social_service_wrap">
                <div class="info_social">
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.name'): </b><span>{{$organization->name}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.city'): </b><span>{{$organization->city}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.street'): </b><span>{{$organization->street}}</span>
                    </div>

                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.house'): </b><span>{{$organization->house}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.office'): </b><span>{{$organization->office}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.phone'): </b><span>{{$organization->phone}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <b>@lang('main.social_service.email'): </b><span>{{$organization->email}}</span>
                    </div>
                    <div class="card-block mb-3">
                        <a href="{{route('volunteer.create',$organization->id)}}"
                           class="btn btn-secondary btn-sm">@lang('main.social_service.add_co_work')</a>
                        <a href="{{route('organization.statement.create',$organization->id)}}"
                           class="btn btn-primary btn-sm">@lang('main.statement.form_title')</a>
                        <a href="{{  route('organization.event.create', ['organization' => $organization->slug]) }}" class="btn btn-sm btn-warning">
                             @lang('main.menu.create_event')
                        </a>
                    </div>
                </div>
                <div class="co_workers">
                    <table class="table table-hover">
                        <thead>
                            <th>@lang('main.user.surname')</th>
                            <th>@lang('main.user.name')</th>
                            <th>@lang('main.user.position')</th>
                            <th>@lang('main.global.delete')</th>
                            </thead>
                        <tbody>
                        @forelse($organization->users as $user)
                            <tr>
                                <td>{{$user->surname}}</td>
                                <td>{{$user->name}} </td>
                                <td>{{$user->position}} </td>
                                <td>
                                    <a href="{{route('user.delete',$user->id)}}" class="btn btn-sm btn-danger">
                                        @lang('main.global.delete')
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="4" class="text-center">
                                    @lang('main.organization.no_co_works')
                                </th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

