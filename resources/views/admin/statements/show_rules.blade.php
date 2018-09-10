@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.statement.show_rules')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>
                @lang('main.statement.show_rules'): {{$statement->title}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <th>@lang('main.rule.rule')</th>
                    <th>@lang('main.rule.type')</th>
                    <th>@lang('main.rule.data')</th>
                    </thead>
                    <tbody>

                    @forelse($rules as $rule)
                        <tr>
                            <td>{{$rule['lang']}}</td>
                            <td>{{$rule['type']}}</td>
                            @if(!empty($rule['data']))
                                <td>
                                    <a href="{{(!empty($rule['data']))? $rule['data'] :''}}">@lang('main.global.view')</a>
                                </td>

                            @else
                                <td>{{$lang}}</td>

                            @endif
                        </tr>
                    @empty
                        <tr>
                            <th colspan="4" class="text-center">@lang('main.rule.no_rules')</th>
                        </tr>
                    @endforelse

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection