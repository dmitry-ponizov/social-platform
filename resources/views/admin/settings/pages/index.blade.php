@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            @lang('main.global.settings')
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.pages')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.menu.pages')
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-statements table-bordered text-center">
                    <thead class="thead-dark">
                    <th>@lang('main.global.title')</th>
                    <th>@lang('main.pages.elements')</th>
                    </thead>
                    <tbody>
                    @foreach($pages as $page)
                        <tr>
                            <td>@lang("main.pages.".$page)</td>
                            <td><a class="btn btn-sm btn-secondary"
                                   href="{{route('page.elements',$page)}}">@lang('main.global.edit')</a></td>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection