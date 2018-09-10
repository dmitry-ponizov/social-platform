@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('partners')}}">@lang('main.menu.partners')</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('partners')}}">@lang('main.menu.partners_list')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.edit_partner')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user" aria-hidden="true"></i>
                @lang('main.menu.edit_partner'): {{ $partner['data']['name'] }}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('partners.update', $partner['data']['slug'])}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <label for="name">@lang('main.global.name')</label>
                        <input name="name" type="text" value="{{ $partner['data']['name'] }}" class="form-control" />
                        <span class="text-danger">{{$errors->first('name')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="url">@lang('main.partners.url')</label>
                        <input id="url" name="url" type="text" value="{{ $partner['data']['url'] }}" class="form-control" />
                        <span class="text-danger">{{$errors->first('url')}}</span>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.menu.photo')</label>
                        <input name="photo" type="file" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.partners.about')</label>
                        <textarea name="about" type="text" value="{{ $partner['data']['about'] }}" class="form-control">{{ $partner['data']['about'] }}</textarea>
                        <span class="text-danger">{{$errors->first('about')}}</span>
                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.user.update_user')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection