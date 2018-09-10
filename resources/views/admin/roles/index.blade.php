@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.role.roles_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.role.roles_list')
            </div>
            <a href="{{route('role.create')}}" class="btn btn-sm btn-primary"> + @lang('main.menu.create_role')</a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-head thead-dark text-center">
                    <th class="middle-cell text-center">@lang('main.role.role')</th>
                    @foreach($data['fields'] as $permission=>$field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach
                    </thead>
                    <tbody class="text-center">
                    @forelse($data['roles'] as $role)
                        <tr>
                            <td>{{$role['name']}}</td>
                            @foreach($data['fields'] as $permission=>$field)
                                <td><a href="{{route($field['route'],$role['id'])}}" class="btn btn-sm {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.role.no_roles')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection