@extends('layouts.admin')

@section('content')
    <div>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/organizations">@lang('main.global.organizations')</a>
            </li>
            <li class="breadcrumb-item">
                <a href="/admin/organizations/show/{{$id}}">@lang('main.organization.view')</a>
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
                    <create-statement-form type="organization" :id="{{ json_encode($id) }}" />
                </div>
            </div>
        </div>
    </div>

@endsection