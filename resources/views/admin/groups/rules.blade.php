@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.group.rules')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>
                @lang('main.group.rules_group'): {{$data['group']->lang}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('rules.groups.update',$data['group']->id)}}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover">
                        <thead>
                        <th>@lang('main.rule.rules')</th>
                        <th>@lang('main.group.change_group')</th>
                        </thead>
                        <tbody>
                        @forelse($data['rules'] as $rule_id =>$rule)
                            <tr>
                                <td>{{$rule['title']}}</td>
                                <td>
                                    <select name="{{$rule_id}}" id="" class="form-control group_select">
                                        @foreach($data['groups'] as $id=>$group)
                                            <option {{(isset($group['selected'])) ? 'selected' :''}} value="{{$id}}">{{$group['title']}}</option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="2" class="text-center">@lang('main.rule.no_rules')</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    @if(!empty($data['rules']))
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.global.save_changes')</button>
                        </div>
                    @endif
                    <a href="{{route('rules')}}" class="btn btn-xs btn-secondary">@lang('main.rule.rules_list')</a>
                </form>
            </div>
        </div>
    </div>

@endsection