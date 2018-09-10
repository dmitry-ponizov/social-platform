@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.permission.edit_roles')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i> @lang('main.permission.edit_roles_permission'): {{$permission->lang}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('permission.roles.update',$permission->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover">
                        <thead>
                        <th>@lang('main.global.role')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>

                        @forelse($roles as $role)
                            <tr>
                                <td>{{$role['lang']}}</td>
                                <td><input type="checkbox" name="roles[]" value="{{$role['id']}}" {{(isset($role['checked']))?'checked':''}}>
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
                        <button class="btn btn-dark" type="submit">@lang('main.global.save_changes')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection