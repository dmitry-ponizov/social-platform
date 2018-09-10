@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.offer.list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.offer.list')
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-offers table-bordered text-center">
                    <thead class="thead-dark">
                    <th>@lang('main.global.title')</th>
                    <th>@lang('main.global.user')</th>

                    @foreach($data['fields'] as $statement=>$field)
                        <th>{{$field['th_name']}}</th>
                    @endforeach
                    </thead>
                    <tbody>
                    @forelse($data['offers'] as $offer)
                        <tr>
                            <td>{{$offer['title']}}</td>
                            <td>{{$offer['user']}}</td>
                            @if(isset($offer['fields']))

                            @endif
                            @foreach($data['fields'] as $field)
                                 <td><a href="{{route($field['route'],$offer['id'])}}" class="btn btn-xs {{$field['button']}}">{{$field['name']}}</a></td>
                            @endforeach
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.offer.no_offers')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection