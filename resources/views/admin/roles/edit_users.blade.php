@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.role.edit_users')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> @lang('main.role.edit_role_users'): {{$role->lang}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('role.users.update',$role->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <th>@lang('main.role.users')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{$user['name']}}</td>
                                <td><input type="checkbox" name="users[]" value="{{$user['id']}}" {{(isset($user['checked']))?'checked':''}}></td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="6" class="text-center">@lang('main.role.no_roles')</th>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-success" type="submit">@lang('main.global.save_changes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection