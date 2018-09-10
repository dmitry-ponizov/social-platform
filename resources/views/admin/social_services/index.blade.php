@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.social_services')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.social_service.list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table fa-fw"></i>@lang('main.global.social_services')
            </div>
            <a href="{{route('social_service.create')}}" class="btn btn-sm btn-primary">
                + @lang('main.social_service.create')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover table-bordered text-center">
                    <thead class="table-head thead-dark">
                        <th class="big-cell">@lang('main.social_service.name')</th>
                        <th>@lang('main.global.view')</th>
                        <th>@lang('main.global.edit')</th>
                    </thead>
                    <tbody>
                    @forelse($social_services as $service)
                        <tr>
                            <td>{{$service->name}}</td>
                            <td>
                                <a href="{{route('show.social_service',$service->id)}}"
                                   class="btn btn-sm btn-info">@lang('main.social_service.detail')</a>
                            </td>
                            <td>
                                <a href="{{route('edit.social_service',$service->id)}}"
                                   class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.social_service.no_services')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{$social_services->links()}}
@endsection