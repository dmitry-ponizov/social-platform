@extends('layouts.app')

@section('content')

    <header-component></header-component>
    <nav-component :lang="{{json_encode(\Lang::get('main.nav_menu'))}}"></nav-component>
    <volunteer-details
            :volunteer="{{ json_encode($volunteer) }}"
            locale="{{ \App::getLocale() }}">
    </volunteer-details>
    <footer-component></footer-component>
@endsection