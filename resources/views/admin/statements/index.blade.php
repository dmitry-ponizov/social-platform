@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.statement.list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.statement.list')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-statements">
                    <thead class="thead-dark">
                        <th>@lang('main.global.title')</th>
                        <th>@lang('main.global.user')</th>
                        <th>@lang('main.global.category')</th>
                        <th>@lang('main.statement.status')</th>
                        <th>@lang('main.statement.published')</th>
                        @foreach($data['fields'] as $statement=>$field)
                            <th>{{$field['th_name']}}</th>
                        @endforeach
                        </thead>
                    <tbody>
                    @forelse($data['statements'] as $statement)
                        <tr>
                            <td>{{$statement['title']}}</td>
                            <td>{{$statement['user']}}</td>
                            <td>{{$statement['category']}}</td>
                            <td>@lang('main.statement.statuses.'.$statement['status'])</td>
                            <td>
                                <a href="{{route($statement['published']['route'],$statement['id'])}}"
                                   class="btn btn-sm {{$statement['published']['button']}}">
                                    {{$statement['published']['name']}}
                                </a>
                            </td>
                            @foreach($data['fields'] as $field)
                                <td>
                                    <a href="{{route($field['route'],$statement['id'])}}"
                                       class="btn btn-sm {{$field['button']}}">{{$field['name']}}
                                    </a>
                                </td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">
                                @lang('main.statement.no_statements')
                            </th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    {{ $data['pages']->links() }}
@endsection