@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.organizations_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table fa-fw"></i>
                @lang('main.menu.organizations_list')
            </div>
            <a href="{{ url('/admin/organizations/create')}}" class="btn btn-sm btn-primary">
                + @lang('main.menu.create_organization')
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-head thead-dark">
                    <th class="big-cell text-center">@lang('main.social_service.name')</th>
                    <th class="text-center">@lang('main.menu.events')</th>
                    <th class="text-center">@lang('main.global.statements')</th>
                    <th class="text-center">@lang('main.global.view')</th>
                    <th class="text-center">@lang('main.global.edit')</th>
                    <th class="text-center">@lang('main.global.blocked')</th>
                    </thead>
                    <tbody>
                    @forelse($organizations as $organization)
                        <tr>
                            <td>{{$organization->name}}</td>
                            <td class="text-center">
                                <a href="{{ route('organizations.events',['organization' => $organization->slug]) }}"
                                   class="btn btn-sm btn-info">@lang('main.global.detail')</a>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('organizations.statements',$organization->id) }}"
                                   class="btn btn-sm btn-info">@lang('main.global.detail')</a>
                            </td>

                            <td class="text-center">
                                <a href="{{route('organizations.show',$organization->id)}}"
                                   class="btn btn-sm btn-info">@lang('main.social_service.detail')</a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('organizations.edit',$organization->id)}}"
                                   class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('organizations.block',$organization->id)}}"
                                   class="btn btn-sm {{ ($organization->block) ? 'btn-primary' :  'btn-danger'}}">
                                    @lang(($organization->block) ? 'main.global.cancel': 'main.global.block' )
                                </a>
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
    {{ $organizations->links() }}
@endsection