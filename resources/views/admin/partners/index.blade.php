@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.menu.partners')</a>
        </li>
        <li class="breadcrumb-item active"> @lang('main.menu.partners_list')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table fa-fw"></i>
                @lang('main.menu.partners_list')
            </div>
            <a href="{{ url('/admin/partners/create')}}" class="btn btn-sm btn-primary">
                + @lang('main.menu.create_partner')
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-head thead-dark">
                        <th class="text-center">@lang('main.menu.photo')</th>
                        <th class="big-cell text-center">@lang('main.menu.title')</th>
                        <th class="text-center">@lang('main.global.view')</th>
                        <th class="text-center">@lang('main.menu.publish')</th>
                        <th class="text-center">@lang('main.global.edit')</th>
                        <th class="text-center">@lang('main.global.delete')</th>
                    </thead>
                    <tbody>
                    @forelse($partners['data'] as $partner)
                        <tr>
                            <td><img style="width: 50px;height: 50px;border:1px solid black; border-radius: 50%"
                                     src="{{$partner['photo']}}" alt=""></td>
                            <td>{{ $partner['name'] }}</td>
                            <td class="text-center">
                                <a href="{{route('partners.show', $partner['slug'])}}"
                                   class="btn btn-sm btn-info">@lang('main.social_service.detail')</a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('partners.publish', $partner['slug'])}}"
                                   class="btn btn-sm {{ ($partner['publish']) ? 'btn-primary' :  'btn-danger'}}">
                                    @lang(($partner['publish']) ? 'main.partners.publish': 'main.partners.not_publish' )
                                </a>
                            </td>
                            <td class="text-center">
                                <a href="{{route('partners.edit', $partner['slug'])}}"
                                   class="btn btn-sm btn-secondary">@lang('main.global.edit')</a>
                            </td>
                            <td>
                                <form method="post" action="{{route('partners.delete', $partner['slug']) }}">
                                    {{ csrf_field() }}
                                    {{ method_field('delete') }}
                                    <button type="submit" class="btn btn-sm btn-danger">@lang('main.global.delete')</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <th colspan="6" class="text-center">@lang('main.partners.no_partners')</th>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection