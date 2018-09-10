@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.permission.edit_permissions')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>
                @lang('main.permission.edit_permissions_user'): {{$user->name}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('user.permissions.update',$user->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <th>@lang('main.permission.permission')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>

                        @forelse($permissions as $permission)
                            <tr>
                                <td>{{$permission['lang']}}</td>
                                <td><input type="checkbox" name="permissions[]" value="{{$permission['id']}}" {{(isset($permission['checked']))?'checked':''}}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="2" class="text-center">No permissions</th>
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