@extends('layouts.admin')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{route('admin.main')}}">@lang('main.global.main')</a>
        </li>
        <li class="breadcrumb-item">
            @lang('main.global.settings')
        </li>
        <li class="breadcrumb-item active">@lang('main.menu.elements')</li>
    </ol>
    <div class="card mb-3">
        <div class="card-header">
            <div>
                <i class="fa fa-table"></i> @lang('main.menu.elements')
            </div>
        </div>
        {{-- {{dd($fields)}} --}}
        <div class="card-body">
            <form action="{{route('footer.update.company')}}" method="POST" id="left_banner_form"
                  enctype="multipart/form-data">
                {{csrf_field()}}
                <table class="table table-hover table-statements table-bordered text-center">
                    <thead class="thead-dark">
                    <th>Title</th>
                    <th>en</th>
                    <th>ru</th>
                    <th>ua</th>
                    </thead>
                    <tbody>
                    <tr>
                        <td><span class="form-label">@lang('main.elements.logo')</span></td>
                        <td colspan="3">
                            <label>
                                <img src="{{$fields['ru']->logo}}" alt="">
                                <input type="file" name="logo">
                            </label>
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.description')</label></td>
                        <td><textarea type="text" name="description[en]"
                                      class="form-control">{{$fields['en']->description}}</textarea></td>
                        <td><textarea type="text" name="description[ru]"
                                      class="form-control">{{$fields['ru']->description}}</textarea></td>
                        <td><textarea type="text" name="description[ua]"
                                      class="form-control">{{$fields['ua']->description}}</textarea></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_url')</label></td>
                        <td colspan="3"><input type="text" name="link_url" class="form-control"
                                               value="{{$fields['en']->link_url}}"></td>

                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_title')</label></td>
                        <td><input type="text" name="link_title[en]" class="form-control"
                                   value="{{$fields['en']->link_title}}"></td>
                        <td><input type="text" name="link_title[ru]" class="form-control"
                                   value="{{$fields['ru']->link_title}}"></td>
                        <td><input type="text" name="link_title[ua]" class="form-control"
                                   value="{{$fields['ua']->link_title}}"></td>
                    </tr>


                    <tr>
                        <td><label class="form-label">@lang('main.elements.facebook')</label></td>
                        <td colspan="3"><input type="text" name="facebook" class="form-control"
                                               value="{{$fields['en']->facebook}}"></td>

                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.twitter')</label></td>
                        <td colspan="3"><input type="text" name="twitter" class="form-control"
                                               value="{{$fields['en']->twitter}}"></td>

                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.skype')</label></td>
                        <td colspan="3"><input type="text" name="skype" class="form-control"
                                               value="{{$fields['en']->skype}}"></td>

                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.google')</label></td>
                        <td colspan="3"><input type="text" name="google" class="form-control"
                                               value="{{$fields['en']->google}}"></td>

                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.youtube')</label></td>
                        <td colspan="3"><input type="text" name="youtube" class="form-control"
                                               value="{{$fields['en']->youtube}}"></td>

                    </tr>

                    </tbody>
                </table>
                <div class="d-flex justify-content-center">
                    <button class="btn btn-xs btn-success">@lang('main.elements.save')</button>
                </div>
            </form>
        </div>

    </div>

@endsection