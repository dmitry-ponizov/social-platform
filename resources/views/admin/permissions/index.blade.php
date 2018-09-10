@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.permission.list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.permission.list')
            </div>

            <a href="{{route('permission.create')}}" class="btn btn-sm btn-primary"> + @lang('main.menu.create_permission')</a>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-head thead-dark">
                    <th class="middle-cell">@lang('main.global.title')</th>
                    @foreach($data['fields'] as $permission=>$field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach
                    </thead>
                    <tbody>
                    @forelse($data['permissions'] as $permission)
                        <tr>
                            <td>{{$permission['lang']}}</td>
                            @foreach($data['fields'] as $field)
                                <td><a href="{{route($field['route'],$permission['id'])}}" class="btn btn-sm {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.permission.no_permissions')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $data['pages']->links() }}
@endsection