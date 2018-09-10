@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.user.edit_roles')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> @lang('main.user.edit_roles_user') : {{$user->name}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('user.roles.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <th>@lang('main.role.role')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>
                        @forelse($roles as $role)
                            <tr>
                                <td>{{$role['lang']}}</td>
                                <td>
                                    <input type="checkbox" name="roles[]" value="{{$role['id']}}" {{(isset($role['checked']))?'checked':''}}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="6" class="text-center">@lang('main.role.no_roles')</th>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                    <div class="text-center">
                        <button class="btn btn-sm btn-success" type="submit">@lang('main.global.save_changes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection