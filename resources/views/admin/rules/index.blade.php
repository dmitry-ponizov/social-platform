@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.rule.rules_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.rule.rules_list')
            </div>
            <a href="{{route('rule.create')}}" class="btn btn-sm btn-primary"> + @lang('main.menu.create_rule')</a>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-borderd text-center">
                    <thead  class="table-head thead-dark">
                    <th  class="middle-cell">@lang('main.rule.rule')</th>
                    <th>@lang('main.rule.type')</th>
                    <th>@lang('main.rule.group')</th>
                    @foreach($data['fields'] as $permission=>$field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach
                    </thead>
                    <tbody>
                    @forelse($data['rules'] as $rule)
                        <tr>
                            <td>{{$rule['name']}}</td>
                            <td>{{$rule['type']}}</td>
                            <td>{{$rule['group']}}</td>
                            @foreach($data['fields'] as $permission=>$field)
                                <td><a href="{{route($field['route'],$rule['id'])}}"
                                       class="btn btn-sm {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.rule.no_rules')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection