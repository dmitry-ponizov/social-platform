@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.user.data_user')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-table"></i>@lang('main.user.data_user'): {{$data['user']->name}}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="table-responsive">
                        <div class="card" style="width: 20rem;">

                            <img class="card-img-top" src="{{asset($data['user']->avatar)}}" alt="Card image cap">
                            <div class="card-block" id="user_cart_block">
                                <h4 class="card-title">{{$data['user']->name}}</h4>
                                <p class="card-text">{{$data['user']->about}}</p>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item">{{$data['user']->types}}</li>
                                <li class="list-group-item">{{$data['user']->phone}}</li>
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        <form action="{{route('user.rules.accept',$data['user']->id)}}" method="POST">
                            {{csrf_field()}}
                            <table class="table table-hover">
                                <thead>
                                <th>@lang('main.rule.rule')</th>
                                <th>@lang('main.rule.type')</th>
                                <th>@lang('main.rule.data')</th>
                                <th>@lang('main.rule.accept')</th>
                                </thead>
                                <tbody>
                                @forelse($data['rules'] as $rule)
                                    <tr>
                                        <td>{{$rule['name']}}</td>
                                        <td>@lang('main.rule.types.'.$rule['type'])</td>
                                        <td>
                                            @if($rule['type']=='file')
                                                <a href="{{asset($rule['data'])}}" target="_blank">
                                                    <img src="{{asset($rule['data'])}}" style="width: 80px;height: 60px" alt="">
                                                </a>
                                            @else
                                                <span>{{$rule['data']}}</span>
                                            @endif
                                        </td>
                                        <td><input {{($rule['accept']? 'checked':'')}} name="rules[]" value="{{$rule['id']}}" type="checkbox"></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <th colspan="4" class="text-center">@lang('main.rule.no_rules')</th>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                            @if(!empty($data['rules']))
                                <button class="btn btn-xs btn-dark">@lang('main.statement.save')</button>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection