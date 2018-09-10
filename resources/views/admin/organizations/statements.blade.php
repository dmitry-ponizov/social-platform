@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">
                @lang('main.global.main')
            </a>
        </li>
        <li class="breadcrumb-item active">
            @lang('main.statement.list')
        </li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i>
                @lang('main.statement.list')
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-statements">
                    <thead class="thead-dark">
                    <th>
                        @lang('main.global.title')
                    </th>
                    <th>
                        @lang('main.global.user')
                    </th>
                    <th>
                        @lang('main.statement.status')
                    </th>
                    <th>
                        @lang('main.global.view')
                    </th>
                    <th>
                        @lang('main.global.edit')
                    </th>
                    <th>
                        @lang('main.global.delete')
                    </th>
                    </thead>
                    <tbody>
                    @forelse($statements as $statement)
                        <tr>
                            <td>
                                {{ $statement->title }}
                            </td>
                            <td>
                                <span>
                                    {{ $statement->surname }}
                                </span>
                                <span>
                                    {{ $statement->user->name }}
                                </span>
                            </td>
                            <td>
                                @lang('main.statement.statuses.'.$statement->status)
                            </td>
                            <td>
                                <a class="btn btn-sm btn-info" href="{{ route('statement.show',$statement->id) }}">
                                    @lang('main.global.detail')
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-secondary" href="{{ route('statement.edit',$statement->id) }}">
                                    @lang('main.global.edit')
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-sm btn-danger" href="{{ route('statement.delete',$statement->id) }}">
                                    @lang('main.global.delete')
                                </a>
                            </td>
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
    {{ $statements->links() }}
@endsection