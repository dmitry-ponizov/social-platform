@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.offer.edit')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-user" aria-hidden="true"></i>
                @lang('main.offer.edit'): {{$offer['title']}}
            </div>

        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('offer.update',$offer['id'])}}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="title" type="text" value="{{$offer['title']}}" class="form-control">
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.user')</label>
                        <select name="user_id" id="" name="user_id" class="form-control">
                            @foreach($users as $user)
                                <option {{($offer['user']==$user->name)?"selected":''}} value="{{$user->id}}">{{$user->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="about">@lang('main.global.description')</label>
                        <textarea name="description" id="about" cols="5" rows="5"
                                  class="form-control">{{$offer['description']}}</textarea>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.global.upload_new_image')</label>
                        <input name="image" type="file" class="form-control">
                        <span class="text-danger">{{$errors->first('image')}}</span>
                    </div>

                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.offer.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection