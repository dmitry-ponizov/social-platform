@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{route('categories')}}">@lang('main.category.list')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.category.subcategories.subcategories')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.category.subcategories.subcategories_list')
                : {{ $category['parent']['lang'] }}
            </div>
            <a href="{{route('subcategories.create', $category['parent']['name'])}}" class="btn btn-sm btn-primary">
                + @lang('main.category.subcategories.create')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead class="table-head thead-dark">
                    <th class="middle-cell">@lang('main.global.title')</th>
                    <th>@lang('main.statement.publish')</th>
                    <th>Правила</th>
                    <th>Заявки</th>
                    <th>Редактировать</th>
                    <th>Удалить</th>
                    </thead>
                    <tbody>
                    @if(isset($category['children']))
                        @foreach($category['children'] as $child)
                            <tr>
                                <td>{{$child['lang']}}</td>
                                <td>
                                    <publish-category :category="{{ json_encode($child) }}"/>
                                </td>
                                <td>
                                    <a href="{{ route('category.edit.rules', $child['id']) }}"
                                       class="btn btn-sm btn-secondary">@lang('main.global.view')</a>
                                </td>
                                <td>
                                    <a href="{{ route('category.view.statements', $child['id']) }}"
                                       class="btn btn-sm btn-secondary">@lang('main.global.view')</a>
                                </td>
                                <td>
                                    <a href="{{ route('subcategory.edit', $child['name']) }}"
                                       class="btn btn-sm btn-dark">@lang('main.global.edit')</a>
                                </td>
                                <td>
                                    <a href="{{ route('category.delete', $child['id']) }}"
                                       class="btn btn-sm  btn-danger">@lang('main.global.delete')</a>
                                </td>

                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.category.subcategories.no_subcategories')</th>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection