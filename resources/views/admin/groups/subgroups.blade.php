@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.group.subgroups_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.rule.group') : {{$data['parent_group']['lang']}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <th>@lang('main.group.subgroup')</th>
                    @foreach($data['fields'] as $field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach
                    </thead>
                    <tbody>
                    @forelse($data['subgroups'] as $subgroup)
                        <tr>
                            <td>{{$subgroup['title']}}</td>
                            @foreach($data['fields'] as $field)
                                <td><a href="{{route($field['route'],$subgroup['id'])}}"
                                       class="btn btn-xs {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.group.no_subgroups')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
                <a href="{{route('create.subgroup',$data['parent_group']['id'])}}" class="btn btn-xs btn-success">@lang('main.group.add_subgroup')</a>
            </div>
        </div>
    </div>

@endsection