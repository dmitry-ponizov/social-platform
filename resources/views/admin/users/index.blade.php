@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.users_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i>@lang('main.menu.users_list')
            </div>

            <a href="{{route('user.create')}}" class="btn btn-sm btn-primary"> + @lang('main.menu.create_user')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered ">
                    <thead class="table-head thead-dark">
                        <th>@lang('main.global.image')
                        <th class="middle-cell text-center">@lang('main.user.surname')</th>
                        <th class="middle-cell text-center">@lang('main.global.name')</th>
                        <th class="middle-cell text-center">@lang('main.elements.phone')</th>
                        @foreach($data['fields'] as $permission=>$field)
                            <th class="text-center">{{$field['th_name']}}</th>
                        @endforeach
                        </thead>
                    <tbody>
                    @forelse($data['users'] as $user)
                        <tr>
                            <td><img src="{{asset($user['avatar'])}}" alt="" width="50px" height="50px"
                                     style="border-radius:50%"></td>
                            <td class="text-center">{{$user['surname']}}</td>
                            <td class="text-center">{{$user['name']}}</td>
                            <td class="text-center">{{$user['phone']}}</td>
                            @if(isset($user['block_user']))
                                <td class="text-center">
                                    <a href="{{ route($user['block_user']['route'],$user['id']) }}"
                                       class="btn btn-sm {{ $user['block_user']['button'] }}">
                                        {{ $user['block_user']['name'] }}
                                    </a>
                                </td>
                            @endif
                            @foreach($data['fields'] as $permission=>$field)
                                @if($permission != 'block_user')
                                    <td class="text-center"><a href="{{route($field['route'],$user['id'])}}"
                                           class="btn btn-sm {{$field['button']}}">{{$field['name']}}</a></td>
                                    @endif
                            @endforeach
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
    {{ $data['data']->links() }}
@endsection