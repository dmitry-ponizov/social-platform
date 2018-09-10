@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="/admin/organizations">@lang('main.global.organizations')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.events')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table fa-fw"></i>
               @lang('main.menu.events_list'): {{ $events['data']['name'] }}
            </div>
            <a href="{{  route('organization.event.create', ['organization' => $events['data']['slug']]) }}" class="btn btn-sm btn-primary">
                + @lang('main.menu.create_event')
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-head thead-dark">
                        <th class="big-cell text-center">@lang('main.menu.short_title')</th>
                        <th class="text-center">@lang('main.events.event_date')</th>
                        <th class="text-center">@lang('main.events.photo')</th>
                        <th class="text-center">@lang('main.global.edit')</th>
                        <th>@lang('main.global.delete')</th>
                    </thead>
                    <tbody>
                    @forelse($events['data']['events']['data'] as $event)
                        <tr>
                            <td>{{ $event['body'] }}</td>
                            <td class="text-center">{{ $event['created_at'] }}</td>
                            <td class="text-center">
                                <div class="photo_wrap">
                                    @foreach($event['photo_report'] as $photo)
                                        <div class="photo_report">
                                            <img class="photo_report_img"  src="{{ $photo }}" alt="">
                                        </div>
                                    @endforeach
                                </div>
                            </td>
                            <td class="text-center">
                                <a href="{{route('organization.event.edit', ['organization' => $event['organization']['data']['slug'],'id' => $event['id']]) }}"
                                   class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            </td>
                            <td class="text-center">
                                <form method="post" action="{{route('organization.event.delete', ['organization' => $event['organization']['data']['slug'],'id' => $event['id']]) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-sm btn-danger">@lang('main.global.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.events.not_events')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection