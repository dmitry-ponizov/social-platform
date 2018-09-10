@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.rule.edit_rules')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-pencil-square-o" aria-hidden="true"></i>
                @lang('main.rule.edit_rules_category'): {{$category->lang}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('category.rules.update',$category->id)}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <table class="table table-hover table-bordered text-center">
                        <thead class="thead-dark">
                        <th>@lang('main.rule.rule')</th>
                        <th>@lang('main.global.access')</th>
                        </thead>
                        <tbody>

                        @forelse($rules as $rule)
                            <tr>
                                <td>{{$rule['lang']}}</td>
                                <td><input type="checkbox" name="rules[]" value="{{$rule['id']}}" {{(isset($rule['checked']))?'checked':''}}>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <th colspan="2" class="text-center">@lang('main.rule.no_rules')</th>
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