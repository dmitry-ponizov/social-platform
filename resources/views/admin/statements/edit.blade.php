@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item active">@lang('main.statement.edit')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                @lang('main.statement.edit'): {{$statement['title']}}
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <form action="{{route('statement.update',$statement['id'])}}" method="POST"
                      enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label for="name">@lang('main.global.title')</label>
                        <input name="title" type="text" value="{{$statement['title']}}" class="form-control">
                    </div>

                    <div class="form-group">
                        <label for="name">@lang('main.global.category')</label>

                        <select name="category_id" id="" class="form-control">
                            @foreach($categories as $category)
                                <option {{($statement['category']==$category['name'])?"selected":''}} value="{{$category['id']}}">{{$category['lang']}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">@lang('main.statement.status')</label>
                        <select name="status" id="" class="form-control">
                            @foreach($statuses as $status)
                                <option {{($statement['status'] == $status) ? "selected":''}} value="{{$status}}">@lang('main.statement.statuses.'.$status)</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="about">@lang('main.global.description')</label>
                        <textarea name="description" id="about" cols="5" rows="5"
                                  class="form-control">{{$statement['description']}}</textarea>
                    </div>
                    <div class="form-group">

                        @forelse ($statement['images'] as $image)
                            <div style="margin-top: 20px">
                                <a href="/uploads/statements/thumb/{{ $image->name }}" target="_blank">
                                    <img style="width: 80px;height: 60px"
                                         src="/uploads/statements/small/{{ $image->name }}">
                                </a>
                                <input style="margin-left: 20px"type="radio" name="main" value="{{$image->id}}" {{(isset($image['main']))?'checked':''}}>
                            </div>

                        @empty
                            <p>No images</p>
                        @endforelse

                    </div>
                    <div class="form-group">
                        <div class="text-center">
                            <button class="btn btn-dark" type="submit">@lang('main.statement.update')</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection