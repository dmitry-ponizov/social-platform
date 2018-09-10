@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.category.list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.category.list')
            </div>
            <a href="{{route('category.create')}}" class="btn btn-sm btn-primary"> + @lang('main.category.create')</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered text-center">
                    <thead  class="table-head thead-dark">
                    <th class="middle-cell">@lang('main.global.title')</th>
                    <th>@lang('main.statement.publish')</th>
                    <th>Подкатегории</th>
                    @foreach($data['fields'] as $category=>$field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach

                    </thead>
                    <tbody>

                    @forelse($data['categories'] as $category)
                        <tr>
                            <td>{{$category['name']}}</td>
                            <td>
                                <publish-category :category="{{ json_encode($category) }}" />
                            </td>
                            <td>
                                <a href="{{ route('subcategories', $category['slug']) }}" class="btn btn-sm btn-secondary">@lang('main.global.view')</a>
                            </td>
                            @foreach($data['fields'] as $field)
                                <td><a href="{{route($field['route'],$category['id'])}}" class="btn btn-sm {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.category.no_categories')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection