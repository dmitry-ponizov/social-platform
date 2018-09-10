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
            <form action="{{route('footer.update.userful_links')}}" method="POST" id="left_banner_form"
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
                        <td><label class="form-label">@lang('main.elements.title')</label></td>
                        <td><input type="text" name="title[en]" class="form-control" value="{{$fields['en']->title}}">
                        </td>
                        <td><input type="text" name="title[ru]" class="form-control" value="{{$fields['ru']->title}}">
                        </td>
                        <td><input type="text" name="title[ua]" class="form-control" value="{{$fields['ua']->title}}">
                        </td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_1')</label></td>
                        <td><input type="text" name="link_1[en]" class="form-control" value="{{$fields['en']->link_1}}">
                        </td>
                        <td><input type="text" name="link_1[ru]" class="form-control" value="{{$fields['ru']->link_1}}">
                        </td>
                        <td><input type="text" name="link_1[ua]" class="form-control" value="{{$fields['ua']->link_1}}">
                        </td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_1_url')</label></td>
                        <td colspan="3"><input type="text" name="link_1_url" class="form-control"
                                               value="{{$fields['en']->link_1_url}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_2')</label></td>
                        <td><input type="text" name="link_2[en]" class="form-control" value="{{$fields['en']->link_2}}">
                        </td>
                        <td><input type="text" name="link_2[ru]" class="form-control" value="{{$fields['ru']->link_2}}">
                        </td>
                        <td><input type="text" name="link_2[ua]" class="form-control" value="{{$fields['ua']->link_2}}">
                        </td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_2_url')</label></td>
                        <td colspan="3"><input type="text" name="link_2_url" class="form-control"
                                               value="{{$fields['en']->link_2_url}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_3')</label></td>
                        <td><input type="text" name="link_3[en]" class="form-control" value="{{$fields['en']->link_3}}">
                        </td>
                        <td><input type="text" name="link_3[ru]" class="form-control" value="{{$fields['ru']->link_3}}">
                        </td>
                        <td><input type="text" name="link_3[ua]" class="form-control" value="{{$fields['ua']->link_3}}">
                        </td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_3_url')</label></td>
                        <td colspan="3"><input type="text" name="link_3_url" class="form-control"
                                               value="{{$fields['en']->link_3_url}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_4')</label></td>
                        <td><input type="text" name="link_4[en]" class="form-control" value="{{$fields['en']->link_4}}">
                        </td>
                        <td><input type="text" name="link_4[ru]" class="form-control" value="{{$fields['ru']->link_4}}">
                        </td>
                        <td><input type="text" name="link_4[ua]" class="form-control" value="{{$fields['ua']->link_4}}">
                        </td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_4_url')</label></td>
                        <td colspan="3"><input type="text" name="link_4_url" class="form-control"
                                               value="{{$fields['en']->link_4_url}}"></td>
                    </tr>
                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_5')</label></td>
                        <td><input type="text" name="link_5[en]" class="form-control" value="{{$fields['en']->link_5}}">
                        </td>
                        <td><input type="text" name="link_5[ru]" class="form-control" value="{{$fields['ru']->link_5}}">
                        </td>
                        <td><input type="text" name="link_5[ua]" class="form-control" value="{{$fields['ua']->link_5}}">
                        </td>
                    </tr>

                    <tr>
                        <td><label class="form-label">@lang('main.elements.link_5_url')</label></td>
                        <td colspan="3"><input type="text" name="link_5_url" class="form-control"
                                               value="{{$fields['en']->link_5_url}}"></td>
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