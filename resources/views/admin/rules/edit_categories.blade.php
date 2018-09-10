@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.rule.edit_categories')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>
                @lang('main.rule.edit_categories_rule'): {{$rule->lang}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('rule.categories.update',$rule->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <th>@lang('main.global.category')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>
                        {{--{{dd($categories)}}--}}
                        @forelse($categories as $category)
                            <tr>
                                <td>{{$category['lang']}}</td>
                                <td><input type="checkbox" name="categories[]" value="{{$category['id']}}" {{(isset($category['checked']))?'checked':''}}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="2" class="text-center">@lang('main.category.no_categories')</th>
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