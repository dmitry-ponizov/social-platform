@extends('layouts.admin')

@section('content')
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/social-services">@lang('main.global.social_services')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/admin/social_service/show/{{$id}}">@lang('main.global.social_service')</a>
            </li>
            <li class="breadcrumb-item active">@lang('main.statement.form_title')</li>
        </ol>
        <div class="card mb-3">
            <div class="card-header">
                <div>
                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i>
                    @lang('main.statement.form_title')
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <create-statement-form type="social-service" :id="{{ json_encode($id) }}" />
                </div>
            </div>
        </div>
    </div>

@endsection