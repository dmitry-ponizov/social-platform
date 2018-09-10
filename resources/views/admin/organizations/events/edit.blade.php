@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/admin/organizations">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.edit_event')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-calendar" aria-hidden="true"></i>
                @lang('main.menu.edit_event'): {{ $event['data']['organization']['data']['name'] }}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <update-event-organization-form
                        :lang="{{ json_encode(\Lang::get('main.events')) }}"
                        :event="{{ json_encode($event['data']) }}"
                ></update-event-organization-form>
            </div>
        </div>
    </div>
@endsection