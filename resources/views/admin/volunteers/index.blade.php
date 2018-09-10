@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.volunteers_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i>@lang('main.menu.volunteers_list')
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">

                <table class="table table-hover table-bordered text-center">
                    <thead class="table-head thead-dark">
                        <th>@lang('main.global.image')</th>
                        <th class="middle-cell">@lang('main.user.surname')</th>
                        <th class="middle-cell">@lang('main.global.name')</th>
                        <th class="middle-cell">@lang('main.elements.phone')</th>
                        <th class="middle-cell">@lang('main.global.blocked')</th>
                        <th class="middle-cell">@lang('main.menu.publish')</th>
                    </thead>
                    <tbody>
                    @forelse($volunteers as $volunteer)
                        <tr>
                            <td>
                                <img src="{{asset($volunteer->avatar)}}" alt="" width="50px" height="50px"
                                     style="border-radius:50%">
                            </td>
                            <td><a class="edit_user" href="{{ route('volunteer.edit',$volunteer->id) }}">{{ $volunteer->surname }}</a></td>
                            <td><a class="edit_user" href="{{ route('volunteer.edit',$volunteer->id) }}">{{ $volunteer->name }}</a></td>
                            <td>{{ $volunteer->phone }}</td>
                            <td>
                                <a class="btn bnt-sm {{ ($volunteer->block) ? 'btn-primary' : 'btn-danger' }}"
                                   href="{{ route('user.block',$volunteer->id) }}">
                                    {{ \Lang::get("main.global.".(($volunteer->block) ? 'cancel':'block')) }}
                                </a>
                            </td>
                            <td>
                                <a class="btn bnt-sm {{ ($volunteer->publish) ? 'btn-success' : 'btn-secondary' }}"
                                   href="{{ route('user.publish',$volunteer->id) }}">
                                    {{ \Lang::get("main.global.".(($volunteer->publish) ? 'publish':'no_publish')) }}
                                </a>
                            </td>
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
    {{ $volunteers->links() }}
@endsection