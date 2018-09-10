@extends('layouts.admin')

@section('content')

    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('partners')}}">@lang('main.menu.partners')</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="{{route('partners')}}">@lang('main.menu.partners_list')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.data_partner')</li>
    </ol>

    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-fw fa-table"></i>@lang('main.menu.data_partner'): {{ $partner['data']['name'] }}
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <div class="table-responsive">
                        <div class="card" style="width: 20rem;">
                            <img class="card-img-top" src="{{asset($partner['data']['photo'])}}" alt="Card image cap">

                        </div>
                    </div>
                </div>
                <div class="col-md-9">
                    <div class="table-responsive">
                        @foreach($partner['data'] as $field => $data)
                            @if($field !== 'slug' && $field !== 'id' && $field !== 'photo')
                                <p>
                                    <strong>@lang('main.partners.'. $field): </strong>
                                    @if($field === 'url')
                                        <a href="{{ $data }}" target="_blank">Link</a>
                                    @elseif($field === 'publish')
                                        @if($data)
                                            @lang('main.partners.publish')
                                        @else
                                            @lang('main.partners.not_publish')
                                        @endif
                                    @else
                                        {{ $data }}
                                    @endif
                                </p>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection